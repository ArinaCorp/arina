<?php

namespace app\modules\plans\models;

use app\components\Excel;
use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use nullref\useful\behaviors\JsonBehavior;
use yii\behaviors\TimestampBehavior;
use PHPExcel_IOFactory;

use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\department\Department;
use app\modules\directories\models\subject\Subject;

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
    public $study_plan_origin;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'JsonBehavior' => [
                'class' => JsonBehavior::className(),
                'fields' => ['graph', 'semesters'],
            ],
            'TimestampBehavior' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'updated',
            ]
        ];
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%study_plan}}';
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
            [['study_plan_origin'], 'checkOrigin', 'on' => 'insert']
        ];
    }

    public function checkOrigin()
    {
        if (!$this->hasErrors()) {
            $record = self::model()->find('(speciality_id =:speciality_id) AND ( year_id = :year_id)',
                array(':speciality_id' => $this->speciality_id, ':year_id' => $this->year_id));
            if (isset($record)) {
                $this->addError('year_id', 'Для даного навчального року вже створений робочий план');
            }
        }
    }


    /**
     * @param $id
     * @return array
     */
    public static function getList($id = NULL)
    {
        /** @var Department $department */
        if (isset($id)) {
            $department = Department::find()->where(['head_id'=>$id])->all();
            if (isset($department)) {
                $list = [];
                foreach($department->specialities as $speciality){
                    $list[$speciality->title] = ArrayHelper::map($speciality->studyPlans, 'id','title');
                }
                return $list;
            }
            return [];
        } else {
            return ArrayHelper::map(StudyPlan::find()->all(),'id', 'title');
        }
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
        return $this->hasOne(SpecialityQualification::className(), ['id' => 'speciality_qualification_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStudySubjects()
    {
        return $this->hasMany(StudySubject::className(), ['study_plan_id' => 'id']);
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
            $name = $cycle->id .' '. $cycle->title;
            if (isset($list[$name])) {
                $list[$name][] = $item;
            } else {
                $list[$name] = [$item];
            }
        }
        return $list;
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
            'created' => Yii::t('app', 'Date of creation'),
            'updated' => Yii::t('app', 'Date of update'),
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
     * Get full title with update datetime
     * @return string
     */
    public function getTitle()
    {
        return $this->specialityQualification->title . ' - ' . date('d.m.Y H:i', $this->created);
    }

    /**
     * @return false|string
     */
    public function getUpdatedForm()
    {
        return date('d.m.Y H:i', $this->updated);
    }

    public function getDocument()
    {
        Yii::$app->excel->makeStudyPlan($this);
    }
}
