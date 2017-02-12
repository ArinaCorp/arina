<?php

namespace app\modules\plans\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use app\modules\directories\models\StudyYear;
use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\department\Department;
use yii\web\HttpException;

/**
 * This is the model class for table "work_plan".
 *
 * The followings are the available columns in table 'work_plan':
 * @property integer $id
 * @property integer $speciality_id
 * @property array $semesters
 * @property array $graphs
 * @property integer $created
 * @property integer $updated
 * @property integer $study_year_id
 *
 * The followings are the available model relations:
 * @property StudyYear $study_year
 * @property WorkSubject[] $work_subjects
 * @property Speciality $speciality
 */
class WorkPlan extends ActiveRecord
{
    /**
     * Allowable difference between the hours of study and work plan
     */
    const HOURS_DIFF = 5;
    public $study_plan_origin;
    public $work_plan_origin;

    /**
     * @return integer
     */
    public function getCourseAmount()
    {
        /** @var StudyPlan $studyPlan */
        $studyPlan = StudyPlan::find()->where(['speciality_id' => $this->speciality_id]);
        if ($studyPlan)
            return count($studyPlan->graphs);
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
        $list = array();
        foreach ($this->work_subjects as $item) {
            if ($item->presentIn($course)){
                $cycle = $item->subject->getCycle($this->speciality_id);
                $name = $cycle->id .' '. $cycle->title;
                if (isset($list[$name])) {
                    $list[$name][] = $item;
                } else {
                    $list[$name] = array($item);
                }
            }
        }
        return $list;
    }

    /**
     * @param $id
     * @return array
     */
    public static function getList($id)
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
            return ArrayHelper::map(self::find()->all(), 'id', 'title');
        }
    }

    /**
     * @return ActiveQuery
     */
    public function getSpeciality()
    {
        return $this->hasOne(Speciality::className(), ['id' => 'speciality_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStudyYear()
    {
        return $this->hasOne(StudyYear::className(), ['id' => 'study_year_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getWorkSubjects()
    {
        return $this->hasMany(StudySubject::className(), ['work_plan_id' => 'id']) ->via('work_subjects');
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'study_year_id' => Yii::t('plans', 'Study year'),
            'speciality_id' => Yii::t('plans', 'Speciality'),
            'created' => Yii::t('plans', 'Date of creation'),
            'updated' => Yii::t('plans', 'Date of update'),
            'study_plan_origin' => Yii::t('plans', 'The study plan for the base'),
            'work_plan_origin' => Yii::t('plans', 'The work plan for the base'),
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['speciality_id, study_year_id', 'required'],
            [
                'semesters', 'required',
                'message' => Yii::t('plans', 'Click "Generate" and check the data'), 'on' => 'graphs'
            ],
            ['speciality_id', 'study_study_year_id', 'uniqueRecord', 'on' => 'insert'],
            ['speciality_id', 'numerical', 'integerOnly' => true],
            ['created', 'default', 'value' => date('Y-m-d', time()), 'on' => 'insert'],
            ['id', 'speciality_id', 'safe', 'on' => 'search'],
            ['study_plan_origin', 'work_plan_origin', 'check_origin', 'on' => 'insert'],
        ];
    }

    public function uniqueRecord()
    {
        if (!$this->hasErrors()) {
            $record = self::find()->where([
                'speciality_id' => $this->speciality_id,
                'study_year_id' => $this->study_year_id
            ]);
            if (isset($record)) {
                $this->addError('study_year_id', Yii::t('plans', 'For this study year work plan has been created'));
            }
        }
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->speciality->title . ' - ' . $this->study_year->getFullName();
    }

    public function checkOrigin()
    {
        if (!$this->hasErrors()) {
            if (empty($this->study_plan_origin) && (empty($this->work_plan_origin))) {
                $this->addError('study_plan_origin, work_plan_origin', Yii::t('plans', 'Choose the plan basis'));
            }
        }
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'JSONBehavior' => [
                'class' => 'application.behaviors.JSONBehavior',
                'fields' => [
                    'graphs'
                ],
            ],
            'StrBehavior' => [
                'class' => 'application.behaviors.StrBehavior',
                'fields' => [
                    'semesters',
                ],
            ],
            'CTimestampBehavior' => [
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
                'setUpdateOnCreate' => true,
            ],
        ];
    }

    /**
     * @return array
     */
    public function checkSubjects()
    {
        $warnings = array();
        foreach ($this->work_subjects as $subject) {
            if (abs(array_sum($subject->total) - (isset($subject->control_hours['total']) ?
                        $subject->control_hours['total'] : 0)) > self::HOURS_DIFF) {
                if (isset($subject->subject))
                    $warnings[] = Yii::t('plans', 'Subject') . $subject->subject->title .
                        Yii::t('plans', 'The total number of hours is different from the curriculum more than on') .
                        self::HOURS_DIFF . Yii::t('plans', 'Hours');
            }
        }
        return implode(Html::tag('br'), $warnings);
    }

    /**
     * @param bool $insert
     * @param array $attributes
     */
    public function afterSave($insert=false, $attributes=[])
    {
        if (!empty($this->work_plan_origin)) {
            $this->copyWorkPlan(WorkPlan::findOne(['id'=>$this->work_plan_origin]));
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
     * @param WorkPlan $origin
     */
    protected function copyWorkPlan($origin)
    {
        $this->graphs = $origin->graphs;
        foreach ($origin->work_subjects as $subject) {
            $model = new WorkSubject();
            $model->attributes = $subject->attributes;
            $model->work_plan_id = $this->id;
            $model->save(false);
        }
    }

    /**
     * @param StudyPlan $origin
     */
    protected function copyFromStudyPlan($origin)
    {
        $groups = $this->speciality->getGroupsByStudyYear($this->study_year_id);
        $graphs = [];
        foreach ($groups as $course) {
            if (isset($origin->graphs[$course - 1])) {
                $graph[] = $origin->graphs[$course - 1];
            }
        }
        $this->graphs = $graphs;
        foreach ($origin->study_subjects as $subject) {
            $model = new WorkSubject();
            $model->work_plan_id = $this->id;
            $model->subject_id = $subject->subject_id;
            $model->dual_lab_work = $subject->dual_lab_work;
            $model->dual_practice = $subject->dual_practice;
            $control_hours = array();
            $control_hours['total'] = $subject->total;
            $control_hours['lectures'] = $subject->lectures;
            $control_hours['lab_works'] = $subject->lab_works;
            $control_hours['practices'] = $subject->practices;
            $model->control_hours = $control_hours;
            $model->weeks = $subject->weeks;
            $model->control = $subject->control;
            $model->save();
        }
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws HttpException
     */
    public function beforeSave($insert=false)
    {
        if ($this->getScenario() == 'graphs') {
            if (count($this->semesters) < 8) throw new HttpException(Yii::t('plans', 'No matching groups to plan'));
        }
        return parent::beforeSave(false);
    }


}