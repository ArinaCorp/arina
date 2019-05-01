<?php

namespace app\modules\plans\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

use nullref\useful\behaviors\JsonBehavior;

use app\modules\directories\models\subject\Subject;
use app\modules\directories\models\cyclic_commission\CyclicCommission;
use app\modules\directories\models\StudyYear;

/**
 * This is the model class for table "work_subject".
 *
 * The followings are the available columns in table 'work_subject':
 * @property integer $id
 * @property integer $subject_id
 * @property integer $work_plan_id
 * @property array $total
 * @property array $lectures
 * @property array $lab_works
 * @property array $practices
 * @property array $weeks
 * @property array $control
 * @property integer $cyclic_commission_id
 * @property string $certificate_name
 * @property string $diploma_name
 * @property integer $project_hours
 * @property array $control_hours
 * @property bool $dual_lab_work
 * @property bool $dual_practice
 *
 * The followings are the available model relations:
 * @property WorkPlan $workPlan
 * @property Subject $subject
 * @property CyclicCommission $cyclicCommission
 */
class WorkSubject extends ActiveRecord
{
    const CONTROL_TEST = 0;
    const CONTROL_EXAM = 1;
    const CONTROL_DPA = 2;
    const CONTROL_DA = 3;
    const CONTROL_WORK = 4;
    const CONTROL_PROJECT = 5;

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'JsonBehavior' => [
                'class' => JSONBehavior::className(),
                'fields' => ['control', 'control_hours', 'total', 'lectures', 'lab_works', 'practices', 'weeks',],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%work_subject}}';
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return (!(empty($this->diploma_name) && empty($this->certificate_name)) ? '* ' : '') . $this->subject->title . (($this->dual_lab_work || $this->dual_practice) ? ' *' : '');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'work_plan_id', 'subject_id', 'cyclic_commission_id', 'project_hours'], 'integer'],
            [['subject_id', 'cyclic_commission_id'], 'required'],
            [['certificate_name', 'diploma_name'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['subject_id', 'total', 'lectures', 'lab_works', 'practices', 'weeks', 'control', 'cyclic_commission_id',
                'certificate_name', 'diploma_name', 'project_hours'], 'safe'],
            [['lectures', 'lab_works', 'practices',], 'default', 'value' => ["", "", "", "", "", "", "", ""]],
            [['total', 'weeks',], 'default', 'value' => ["0", "0", "0", "0", "0", "0", "0", "0"]],
            [['dual_lab_work', 'dual_practice'], 'default', 'value' => 0]
            //[['total', 'lectures', 'lab_works', 'practices', 'weeks', 'control'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'work_plan_id' => Yii::t('plans', 'Work plan'),
            'subject_id' => Yii::t('plans', 'Subject'),
            'total' => Yii::t('plans', 'Total'),
            'lectures' => Yii::t('plans', 'Lectures'),
            'lab_works' => Yii::t('plans', 'Laboratory works'),
            'practices' => Yii::t('plans', 'Practice works'),
            'weeks' => Yii::t('plans', 'Hours per week'),
            'control' => Yii::t('plans', 'Control'),
            'cyclic_commission_id' => Yii::t('app', 'Cyclic commission'),
            'certificate_name' => Yii::t('plans', 'Certificate name'),
            'diploma_name' => Yii::t('plans', 'Diploma name'),
            'project_hours' => Yii::t('plans', 'Project hours'),
            'control_hours' => Yii::t('plans', 'Control hours'),
            'dual_lab_work' => Yii::t('plans', 'Dual laboratory work'),
            'dual_practice' => Yii::t('plans', 'Dual practice work'),
            'test' => Yii::t('plans', 'Test'),
            'exam' => Yii::t('plans', 'Exam'),
            'dpa' => Yii::t('plans', 'DPA'),
            'da' => Yii::t('plans', 'DA'),
            'course_work' => Yii::t('plans', 'Course work'),
            'course_project' => Yii::t('plans', 'Course project'),
            'classes' => Yii::t('plans', 'Classes'),
        ];
    }


    public static function getControlLabelList()
    {
        return [
            self::CONTROL_TEST => Yii::t('plans', 'Test'),
            self::CONTROL_EXAM => Yii::t('plans', 'Exam'),
            self::CONTROL_DPA => Yii::t('plans', 'DPA'),
            self::CONTROL_DA => Yii::t('plans', 'DA'),
            self::CONTROL_WORK => Yii::t('plans', 'Course work'),
            self::CONTROL_PROJECT => Yii::t('plans', 'Course project'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCyclicCommission()
    {
        return $this->hasOne(CyclicCommission::className(), ['id' => 'cyclic_commission_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getWorkPlan()
    {
        return $this->hasOne(WorkPlan::className(), ['id' => 'work_plan_id']);
    }


    /**
     * @param $semester
     * @return integer
     */
    public function getSelfWork($semester)
    {
        return $this->total[$semester] - $this->getClasses($semester);
    }

    /**
     * @param $semester
     * @return integer
     */
    public function getClasses($semester)
    {
//        echo $semester;
//        echo '<br>';
//        var_dump($this->weeks);
//        echo '<br>';
//        var_dump($this->workPlan->semesters);
//        die;
        if($semester>3){ $semester=3;}
        return $this->weeks[$semester] * $this->workPlan->semesters[$semester];
    }

    /**
     * @param $course
     * @return bool
     */
    public function presentIn($course)
    {
        $spring = $course * 2;
        $fall = $spring - 2;
        $spring--;
        return !empty($this->total[$fall]) ||
            !empty($this->weeks[$fall]) ||
            !empty($this->total[$spring]) ||
            !empty($this->weeks[$spring]);
    }

    /**
     * @return bool
     */
    public function hasProject()
    {
        for ($i = 0; $i < count($this->control); $i++)
            if ($this->control[$i][self::CONTROL_PROJECT] || $this->control[$i][self::CONTROL_WORK])
                return true;

        return false;
    }

    /**
     * @param $year
     * @param bool $onlyProjects
     * @return array
     */
    public static function getListByYear($year, $onlyProjects = false)
    {
        /**
         * @var StudyYear $model
         * @var WorkPlan $plan
         */
        $model = StudyYear::find()->where(['id' => $year])->one();
        $subjects = [];

        if ($onlyProjects) {
            foreach ($model->workPlans as $plan)
                foreach ($plan->workSubjects as $subject)
                    if ($subject->hasProject())
                        $subjects[] = $subject;
        } else {
            foreach ($model->workPlans as $plan)
                $subjects = array_merge($subjects, $plan->workSubjects);
        }
        return ArrayHelper::map($subjects, 'id', 'subject.title');
    }

}