<?php

namespace app\modules\plans\models;

use app\components\ExportToExcel;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;

use yii\behaviors\TimestampBehavior;
use nullref\useful\behaviors\JsonBehavior;

use app\modules\directories\models\StudyYear;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\department\Department;
use app\modules\directories\models\subject\Subject;

/**
 * This is the model class for table "work_plan".
 *
 * The followings are the available columns in table 'work_plan':
 * @property integer $id
 * @property integer $speciality_qualification_id
 * @property array $semesters
 * @property array $graph
 * @property integer $created
 * @property integer $updated
 * @property integer $study_year_id
 *
 * The followings are the available model relations:
 * @property StudyYear $studyYear
 * @property WorkSubject[] $workSubjects
 * @property SpecialityQualification $specialityQualification
 */
class WorkPlan extends ActiveRecord
{
    /**
     * Allowable difference between the hours of study and work plan
     */
    const HOURS_DIFF = 5;
    public $study_plan_origin;
    public $work_plan_origin;

    const SCENARIO_GRAPH = 'graph';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_GRAPH] = ['semesters',];
        return $scenarios;
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
            ]
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['speciality_qualification_id', 'study_year_id', 'study_plan_origin'], 'required', 'on' => 'create'],
            [['semesters'], 'required',
                'message' => Yii::t('plans', 'Click "Generate" and check the data'), 'on' => 'graphs'
            ],
            [['study_year_id'], 'unique', 'targetAttribute' => ['study_year_id', 'speciality_qualification_id']],
            [['speciality_qualification_id'], 'integer'],
            [['created', 'updated'], 'safe'],
            [['id', 'speciality_qualification_id'], 'safe', 'on' => 'search'],
            [['study_plan_origin', 'work_plan_origin'], 'checkOrigin', 'on' => 'insert'],
            [['semesters'], 'required', 'on' => self::SCENARIO_GRAPH],

        ];
    }

    /**
     * @return integer
     */
    public function getCourseAmount()
    {
        /** @var StudyPlan $studyPlan */
        $studyPlan = StudyPlan::findOne(['speciality_qualification_id' => $this->speciality_qualification_id]);
        if ($studyPlan)
            return count($studyPlan->graph);
        else
            return 0;
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%work_plan}}';
    }

    /**
     * @param $course
     * @return array
     */
    public function getSubjectsByCycles($course)
    {
        $list = [];
        foreach ($this->workSubjects as $item) {
            if ($item->presentIn($course)) {
                $cycle = $item->subject->getCycle($this->speciality_qualification_id);
                $name = $cycle->id . ' ' . $cycle->title;
                if (isset($list[$name])) {
                    $list[$name][] = $item;
                } else {
                    $list[$name] = [$item];
                }
            }
        }
        return $list;
    }

    /**
     * @param $id
     * @return array
     */
    public static function getList($id = NULL)
    {
        if (isset($id)) {
            /**
             * @var Department $department
             */
            $department = Department::find()->where(['head_id' => $id])->all();
            if (isset($department)) {
                $list = [];
                foreach ($department->specialities as $speciality) {
                    $list[$speciality->title] = ArrayHelper::map($speciality->studyPlans, 'id', 'title');
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
                        return ArrayHelper::map(WorkPlan::find()
                            ->andWhere(['speciality_qualification_id' => $spQIds])
                            ->all(), 'id', 'title');
                    }
                } else {
                    return ArrayHelper::map(WorkPlan::find()->all(), 'id', 'title');
                }
            }
        }
    }

    /**
     * @return ActiveQuery
     */
    public function getSpecialityQualification()
    {
        return $this->hasOne(SpecialityQualification::class, ['id' => 'speciality_qualification_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStudyYear()
    {
        return $this->hasOne(StudyYear::class, ['id' => 'study_year_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getWorkSubjects()
    {
        return $this->hasMany(WorkSubject::class, ['work_plan_id' => 'id']);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'study_year_id' => Yii::t('app', 'Study year'),
            'speciality_qualification_id' => Yii::t('app', 'Speciality qualification'),
            'created' => Yii::t('app', 'Created at'),
            'updated' => Yii::t('app', 'Updated at'),
            'study_plan_origin' => Yii::t('plans', 'The study plan for the base'),
            'work_plan_origin' => Yii::t('plans', 'The work plan for the base'),
            'title' => Yii::t('plans', 'Work plan'),
        ];
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->specialityQualification->getFullTitle() . ' - ' . $this->getYearTitle();
    }

    public function checkOrigin()
    {
        if (!$this->hasErrors()) {
            if (empty($this->study_plan_origin) && (empty($this->work_plan_origin))) {
                $this->addError('study_plan_origin, work_plan_origin', Yii::t('plans', 'Choose the plan for base'));
            }
        }
    }

    /**
     * @return array
     */
    public function checkSubjects()
    {
        $warnings = [];
        foreach ($this->workSubjects as $subject) {
            if (abs(array_sum($subject->total) - (isset($subject->control_hours['total']) ?
                        $subject->control_hours['total'] : 0)) > self::HOURS_DIFF) {
                if (isset($subject->subject))
                    $warnings[] = Yii::t('app', 'Subject') . ' ' . $subject->subject->title . ' ' .
                        Yii::t('plans', 'The total number of hours is different from the curriculum more than on') . ' ' .
                        self::HOURS_DIFF . ' ' . Yii::t('plans', 'OHours');
            }
        }
        return implode(Html::tag('br'), $warnings);
    }

    /**
     * @param WorkPlan $origin
     */
    public function copyFromWorkPlan($origin)
    {
        $this->graph = $origin->graph;
        foreach ($origin->workSubjects as $subject) {
            $model = $subject;
            $model->id = null;
            $model->work_plan_id = $this->id;
            $model->isNewRecord = true;
            $model->save(false);
        }
    }

    /**
     * @param StudyPlan $origin
     */
    public function copyFromStudyPlan($origin)
    {
        $groups = $this->specialityQualification->getGroupsByStudyYear($this->study_year_id);
        $graph = [];
        foreach ($groups as $course) {
            if (isset($origin->graph[$course - 1])) {
                $graph[] = $origin->graph[$course - 1];
            }
        }
        $this->graph = $graph;
        $this->semesters = $origin->semesters;
        foreach ($origin->studySubjects as $subject) {
            $model = new WorkSubject();
            $model->work_plan_id = $this->id;
            $model->subject_id = $subject->subject_id;
            $model->dual_lab_work = $subject->dual_lab_work;
            $model->dual_practice = $subject->dual_practice;
            $control_hours = [];
            $control_hours['total'] = $subject->total;
            $control_hours['lectures'] = $subject->lectures;
            $control_hours['lab_works'] = $subject->lab_works;
            $control_hours['practices'] = $subject->practices;
            $model->control_hours = $control_hours;
            $model->weeks = $subject->weeks;
            $model->control = $subject->control;
            $total = [];
            foreach ($subject->weeks as $id => $hoursPerWeek) {
                // count total hours per semester
                // cast to string, for consistency
                // TODO: decide something about string values in these arrays
                $total[] = (string)($hoursPerWeek * $this->semesters[$id]);
            }
            $model->total = $total;

            // Default hour array
            $defaultArr = ["0", "0", "0", "0", "0", "0", "0", "0"];
            // Check if subject has hours only in one semester
            $valCount = array_count_values($total);
            if (array_key_exists('0', $valCount) && $valCount['0'] == count($total) - 1) {
                // If so, fill in total distributed hours as distributed hours per semester
                foreach ($total as $semester => $hours) {
                    if ((int)$hours > 0) {
                        $lectures = $lab_works = $practices = $defaultArr;
                        $lectures[$semester] = (string)$subject->lectures;
                        $lab_works[$semester] = (string)$subject->lab_works;
                        $practices[$semester] = (string)$subject->practices;
                        $model->lectures = $lectures;
                        $model->lab_works = $lab_works;
                        $model->practices = $practices;
                    }
                }
            } else {
                // Assign default values
                $model->lectures = $model->lab_works = $model->practices = $defaultArr;
            };

            $model->diploma_name = $subject->diploma_name;
            $model->certificate_name = $subject->certificate_name;
            $model->save(false);
        }
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert = false, $changedAttributes = [])
    {
        if (!empty($this->work_plan_origin)) {
            $this->copyFromWorkPlan(WorkPlan::findOne(['id' => $this->work_plan_origin]));
            $this->work_plan_origin = null;
            $this->setIsNewRecord(false);
            $this->save(false);
        } elseif (!empty($this->study_plan_origin)) {
            $this->copyFromStudyPlan(StudyPlan::findOne(['id' => $this->study_plan_origin]));
            $this->study_plan_origin = null;
            $this->setIsNewRecord(false);
            $this->save(false);
        }
    }

    /**
     * @return string
     */
    public function getYearTitle()
    {
        if (isset($this->studyYear)) {
            return $this->studyYear->getFullName();
        }
        return '';
    }

    /**
     * @return false|string
     */
    public function getUpdatedForm()
    {
        return date('d.m.Y H:i', $this->updated);
    }

    /**
     * @return ActiveDataProvider
     */
    public function getWorkPlanSubjectProvider()
    {
        $query = WorkSubject::find()->where(['work_plan_id' => $this->id]);

        $provider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $provider;
    }

    /**
     * @return array
     */
    public function getUnusedSubjects()
    {
        $usedSubjects = ArrayHelper::map($this->workSubjects, 'subject_id', 'id');
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
     * Returns an array of work subjects which are present in defined course
     * @param integer $course
     * @param bool $absentOnes Search those which are absent for defined course
     * @return WorkSubject[]
     */
    public function getSubjectsForCourse($course, $absentOnes = false)
    {
        $result = [];
        foreach ($this->workSubjects as $subject) {
            if ($absentOnes && !$subject->presentIn($course)) {
                $result[] = $subject;
            } elseif (!$absentOnes && $subject->presentIn($course)) {
                $result[] = $subject;
            }
        }
        return $result;
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function getDocument()
    {
        ExportToExcel::getDocument('WorkPlan', $this);
    }

}