<?php

namespace app\modules\plans\models;

use app\components\ExportToExcel;
use app\modules\directories\models\department\Department;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\subject\Subject;
use app\modules\directories\models\subject_cycle\SubjectCycle;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use nullref\useful\behaviors\JsonBehavior;
use nullref\useful\traits\Mappable;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "study_plan".
 *
 * The followings are the available columns in table 'study_plan':
 * @property integer $id
 * @property integer $speciality_qualification_id
 * @property array $semesters
 * @property array $graph
 * @property integer $created
 * @property integer $updated
 *
 * The followings are the available model relations:
 * @property StudySubject[] $studySubjects
 * @property SpecialityQualification $specialityQualification
 */
class StudyPlan extends ActiveRecord
{
    use Mappable;

    public $study_plan_origin;

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%study_plan}}';
    }

    /**
     * @param $headId
     * @return array
     */
    public static function getList($headId = NULL)
    {
        /** @var Department $department */
        if (isset($headId)) {
            $department = Department::find()->where(['head_id' => $headId])->all();
            if (isset($department)) {
                $list = [];
                foreach ($department->specialities as $speciality) {
                    $list[$speciality->title] = ArrayHelper::map($speciality->studyPlans, 'id', 'titleWithDate');
                }
                return $list;
            }
            return [];
        } else {
            if (!Yii::$app->user->isGuest) {
                /** @var User $user */
                $user = Yii::$app->user->identity;

                if (UserHelper::hasRole($user, 'head-of-department')) {
                    if ($user->employee && $user->employee->department) {
                        $spQIds = SpecialityQualification::find()
                            ->andWhere([
                                'speciality_id' => $user->employee->department->getSpecialities()
                                    ->select('id')
                                    ->column(),
                            ])
                            ->select('id')
                            ->column();
                        return ArrayHelper::map(StudyPlan::find()
                            ->andWhere(['speciality_qualification_id' => $spQIds])
                            ->all(), 'id', 'titleWithDate');
                    }
                } else {
                    return ArrayHelper::map(StudyPlan::find()->all(), 'id', 'titleWithDate');
                }
            }
        }
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'JsonBehavior' => [
                'class' => JsonBehavior::class,
                'fields' => ['graph', 'semesters'],
            ],
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'updated',
            ],
        ];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['speciality_qualification_id'], 'required'],
            [['semesters'], 'required', 'message' => Yii::t('plans', 'Click "Generate" and check the data')],
            [['id', 'speciality_qualification_id'], 'integer'],
            [['created', 'updated'], 'safe'],

            [['id', 'speciality_qualification_id'], 'safe', 'on' => 'search'],
            [['id'], 'unique'],
        ];
    }

    /**
     * @return array
     */
    public function getUnusedSubjects()
    {
        $usedSubjects = ArrayHelper::map($this->studySubjects, 'subject_id', 'id');
        $allSubjects = Subject::getListForSpecialityQualification($this->speciality_qualification_id);
        $result = [];
        foreach ($allSubjects as $cycle => $subject) {
            $result[$cycle] = [];
            foreach ($subject as $id => $name) {
                if (!isset($usedSubjects[$id])) {
                    $result[$cycle][$id] = $name;
                }
            }
            if (empty($result[$cycle])) {
                unset($result[$cycle]);
            }
        }
        return $result;
    }

    /**
     * @return ActiveQuery
     */
    public function getSpecialityQualification()
    {
        return $this->hasOne(SpecialityQualification::class, ['id' => 'speciality_qualification_id']);
    }

    /**
     * Group subject by cycles
     * @return array
     */
    public function getSubjectsByCycles()
    {
        $list = [];
        foreach ($this->studySubjects as $item) {
            $cycle = $item->subject->getCycle($this->speciality_qualification_id);
            $name = $cycle->id . ' ' . $cycle->title;
            if (isset($list[$name])) {
                $list[$name][] = $item;
            } else {
                $list[$name] = [$item];
            }
        }
        return $list;
    }

    /**
     * Group subject by cycles
     * @return array
     */
    public function getCyclesWithSubjects()
    {
        $subjectCyclesIds = $this->getStudySubjects()
            ->select(['subject_cycle_id'])
            ->union($this->getStudySubjects()
                ->joinWith('subjectCycle')
                ->select(['subject_cycle.parent_id'])
            )
            ->distinct()
            ->column();

        $subjectCycles = SubjectCycle::find()
            ->where(['id' => $subjectCyclesIds])
            ->all();

        $subjectCycles = SubjectCycle::getTree([], $subjectCycles);

        function mapSubjectsToCycles($subjectCycles, $studySubjects)
        {
            return array_map(function ($subjectCycle) use ($studySubjects) {
                $subjectCycle['subjects'] = array_reduce($studySubjects, function ($acc, StudySubject $item) use ($subjectCycle) {
                    if ($item->subject_cycle_id == $subjectCycle['id']) {
                        $acc[] = $item;
                    }
                    return $acc;
                });
                if (isset($subjectCycle['children'])) {
                    $subjectCycle['children'] = mapSubjectsToCycles($subjectCycle['children'], $studySubjects);
                }
                return $subjectCycle;
            }, $subjectCycles);
        }

        return mapSubjectsToCycles($subjectCycles, $this->studySubjects);
    }

    /**
     * @return ActiveQuery
     */
    public function getStudySubjects()
    {
        return $this->hasMany(StudySubject::class, ['study_plan_id' => 'id']);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'speciality_qualification_id' => Yii::t('app', 'Speciality qualification'),
            'semesters' => Yii::t('plans', 'Semesters'),
            'graph' => Yii::t('plans', 'Graph'),
            'created' => Yii::t('app', 'Created at'),
            'updated' => Yii::t('app', 'Updated at'),
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = StudyPlan::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'speciality_qualification_id' => $this->speciality_qualification_id,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'semesters', $this->semesters])
            ->andFilterWhere(['like', 'graph', $this->graph]);
        return $dataProvider;
    }

    /**
     * @return ActiveDataProvider
     */
    public function getStudyPlanStudySubjectProvider()
    {
        $query = StudySubject::find()->where(['study_plan_id' => $this->id]);

        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $provider;
    }

    /**
     * @return string
     */
    public function getTitleWithDate()
    {
        return $this->getTitle() . ' - ' . date('d.m.Y H:i', $this->created);
    }

    /**
     * Get full title with update datetime
     * @return string
     */
    public function getTitle()
    {
        return $this->specialityQualification->getFullTitle();
    }

    /**
     * @return false|string
     */
    public function getUpdatedForm()
    {
        return date('d.m.Y H:i', $this->updated);
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function getDocument()
    {
//        Yii::$app->excel->makeStudyPlan($this);
        ExportToExcel::getDocument('StudyPlan', $this);
    }
}
