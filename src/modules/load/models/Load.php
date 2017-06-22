<?php

namespace app\modules\load\models;

use app\modules\plans\models\WorkPlan;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use nullref\useful\JsonBehavior;
use yii\web\NotFoundHttpException;

use app\modules\directories\models\StudyYear;
use app\modules\students\models\Group;
use app\modules\employee\models\Employee;
use app\modules\plans\models\WorkSubject;

/**
 *
 * This is the model class for table "load".
 *
 * The followings are the available columns in table 'load':
 * @property integer $id
 * @property integer $study_year_id
 * @property integer $employee_id
 * @property integer $group_id
 * @property integer $work_subject_id
 * @property integer $type
 * @property integer $course
 * @property array $consult
 * @property array $students
 * @property array $fall_hours
 * @property array $spring_hours
 *
 * The followings are the available model relations:
 * @property StudyYear $studyYear
 * @property Group $group
 * @property Employee $employee
 * @property WorkSubject $workSubject
 */
class Load extends ActiveRecord
{
    const TYPE_LECTURES = 1;
    const TYPE_PRACTICES = 2;
    const TYPE_LAB_WORKS = 3;
    const TYPE_PROJECT = 4;

    const HOURS_WORKS = 0;
    const HOURS_DKK = 1;
    const HOURS_PROJECT = 2;
    const HOURS_CHECK = 3;
    const HOURS_CONTROL = 4;

    protected $WORK_RATE = [1, 1, 1];
    protected $PROJECT_RATE = [2, 1, 1];
    protected $DIPLOMA_RATE = [4, 4, 4];

    public $commissionId;

    public $workType;

    protected static $HOURS = ['', '', '', '', ''];

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%load}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['fall_hours'], 'default', 'setOnEmpty' => false, 'safe' => true,
                'value' => !empty($this->fall_hours) ? ArrayHelper::merge(self::$HOURS, $this->fall_hours) : self::$HOURS],
            [['spring_hours'], 'default', 'setOnEmpty' => false, 'safe' => true,
                'value' => !empty($this->spring_hours) ? ArrayHelper::merge(self::$HOURS, $this->spring_hours) : self::$HOURS],
            [['consult'], 'validateConsultation'],
            [['teacher_id'], 'required', 'on' => 'project'],
        ];
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
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'group_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getWorkSubject()
    {
        return $this->hasOne(WorkSubject::className(), ['id' => 'work_subject_id']);
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'JsonBehavior' => [
                'class' => JsonBehavior::className(),
                'fields' => ['consult', 'students', 'fall_hours', 'spring_hours'],
            ],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'course' => Yii::t('app', 'Course'),
            'employee_id' => Yii::t('app', 'Employee'),
            'commissionId' => Yii::t('app', 'Cycle commission'),
            'fall_hours[0]' => Yii::t('load', 'Calculation and control works'),
            'fall_hours[1]' => Yii::t('load', 'Practice management, diploma control, state qualification commissions'),
            'spring_hours[0]' => Yii::t('load', 'Calculation and control works'),
            'spring_hours[1]' => Yii::t('load', 'Practice management, diploma control, state qualification commissions'),
            'consult[0]' => Yii::t('load', 'Consultations'),
            'consult[1]' => Yii::t('load', 'Consultations'),
            'wp_subject_id' => Yii::t('plans', 'Work subject'),
            'students[0]' => Yii::t('load', 'Total students'),
            'students[1]' => Yii::t('load', 'Total students on budget'),
            'students[2]' => Yii::t('load', 'Total students on contract'),
            'workType' => Yii::t('load', 'Project type'),
            'group_id' => Yii::t('app', 'Group'),
        ];
    }

    /**
     * @return float
     */
    public function getBudgetPercent()
    {
        if ($this->getStudentsCount() == 0) {
            return 0;
        }
        return floor(($this->getBudgetStudentsCount() / $this->getStudentsCount()) * 100);
    }

    /**
     * @return int
     */
    public function getStudentsCount()
    {
        if (isset($this->students[0])) {
            return $this->students[0];
        } else {
            return count($this->group->getStudentsArray());
        }
    }

    /**
     * @return int
     */
    public function getBudgetStudentsCount()
    {
        if (isset($this->students[1])) {
            return $this->students[1];
        } else {
            return $this->group->getCountByPayment(1);
        }
    }

    /**
     * @return float
     */
    public function getContractPercent()
    {
        if ($this->getStudentsCount() == 0) {
            return 0;
        }
        return floor(($this->getContractStudentsCount() / $this->getStudentsCount()) * 100);
    }

    /**
     * @return int
     */
    public function getContractStudentsCount()
    {
        if (isset($this->students[2])) {
            return $this->students[2];
        } else {
            return $this->group->getCountByPayment(2);
        }
    }

    /**
     * @param $semester
     * @return string
     */
    public function getLectures($semester)
    {
        if ($this->type != self::TYPE_LECTURES) {
            return '';
        }
        return $this->workSubject->lectures[$semester];
    }

    /**
     * @param $semester
     * @return string
     */
    public function getLabs($semester)
    {
        if ($this->type != self::TYPE_LAB_WORKS) {
            return '';
        }
        return $this->workSubject->lab_works[$semester];
    }

    /**
     * @param int $semester
     * @return string
     */
    public function getPractices($semester)
    {
        if ($this->type != self::TYPE_PRACTICES) {
            return '';
        }
        return $this->workSubject->practices[$semester];
    }

    /**
     * @param int $semester
     * @return string
     */
    public function getControlWorks($semester)
    {

        if ($semester & 1) {
            return isset($this->fall_hours[self::HOURS_WORKS]) ? $this->fall_hours[self::HOURS_WORKS] : '';
        } else {
            return isset($this->spring_hours[self::HOURS_WORKS]) ? $this->spring_hours[self::HOURS_WORKS] : '';
        }
    }

    /**
     * @param $semester
     * @return string
     */
    public function getDkk($semester)
    {
        if ($semester & 1) {
            return isset($this->fall_hours[self::HOURS_DKK]) ? $this->fall_hours[self::HOURS_DKK] : '';
        } else {
            return isset($this->spring_hours[self::HOURS_DKK]) ? $this->spring_hours[self::HOURS_DKK] : '';
        }
    }

    /**
     * @param int $semester
     * @return string
     */
    public function getTotal($semester)
    {
        if ($this->type == self::TYPE_PROJECT) return '';
        $total = $this->workSubject->total[$semester];
        return !empty($total) ? $total : '';
    }

    /**
     * @param int $semester
     * @return string
     */
    public function getSelfWork($semester)
    {
        if ($this->type == self::TYPE_PROJECT) return '';
        $selfWork = $this->workSubject->getSelfWork($semester);
        return !empty($selfWork) ? $selfWork : '';
    }

    /**
     * @param int $semester
     * @return int
     */
    public function getPay($semester)
    {
        return intval($this->getClasses($semester)) + intval($this->getProject($semester)) +
            intval($this->getCheck($semester)) + intval($this->getControl($semester)) +
            intval($this->getConsultation($semester)) +
            intval($this->getExam($semester)) + intval($this->getTest($semester));
    }

    /**
     * @param int $semester
     * @return string
     */
    public function getClasses($semester)
    {
        if ($this->type == self::TYPE_PROJECT) return '';
        $classes = $this->workSubject->getClasses($semester);
        return !empty($classes) ? $classes : '';
    }

    /**
     * @param int $semester
     * @return string
     */
    public function getProject($semester)
    {
        if ($semester & 1) {
            $project = $this->fall_hours[self::HOURS_PROJECT];
        } else {
            $project = $this->spring_hours[self::HOURS_PROJECT];
        }
        return !empty($project) ? $project : '';
    }

    /**
     * @param int $semester
     * @return string
     */
    public function getCheck($semester)
    {
        if ($semester & 1) {
            $check = $this->fall_hours[self::HOURS_CHECK];
        } else {
            $check = $this->spring_hours[self::HOURS_CHECK];
        }
        return !empty($check) ? $check : '';
    }

    /**
     * @param int $semester
     * @return string
     */
    public function getControl($semester)
    {
        if ($semester & 1) {
            $control = $this->fall_hours[self::HOURS_CONTROL];
        } else {
            $control = $this->spring_hours[self::HOURS_CONTROL];
        }
        return !empty($control) ? $control : '';
    }

    /**
     * @param int $semester
     * @return float
     */
    public function getConsultation($semester)
    {
        if ($this->type == self::TYPE_PROJECT) return '';
        if ($semester & 1) {
            $consult = $this->consult[0];
        } else {
            $consult = $this->consult[1];
        }
        return isset($consult) ? $consult : $this->calcConsultation($semester);
    }

    /**
     * @param int $semester
     * @return float
     */
    public function calcConsultation($semester)
    {
        if ($this->type == self::TYPE_PROJECT) return 0;
        $control = $this->workSubject->control[$semester - 1];
        return floor(
                $this->workSubject->total[$semester - 1] * 0.06
            ) + ($control[WorkSubject::CONTROL_EXAM] || $control[WorkSubject::CONTROL_DPA] ? 2 : 0);
    }

    /**
     * @param int $semester
     * @return float
     */
    public function getExam($semester)
    {
        if ($this->type == self::TYPE_PROJECT) return '';
        $control = $this->workSubject->control[$semester];
        if (!$control[WorkSubject::CONTROL_EXAM] && !$control[WorkSubject::CONTROL_DPA]) {
            return 0;
        }
        $k = $control[WorkSubject::CONTROL_EXAM] ? 0.33 : 0.5;
        return floor(count($this->group->getStudentsArray()) * $k);
    }

    /**
     * @param int $semester
     * @return int
     */
    public function getTest($semester)
    {
        if ($this->type == self::TYPE_PROJECT) return '';
        $control = $this->workSubject->control[$semester];
        if ($control[WorkSubject::CONTROL_TEST]) {
            return 2;
        } else {
            return 0;
        }
    }

    /**
     * @return float|string
     */
    public function getPlanCredits()
    {
        if ($this->type == self::TYPE_PROJECT) return '';
        return round($this->getPlanTotal() / 54, 2);
    }

    /**
     * @return int
     */
    public function getPlanTotal()
    {
        if ($this->type == self::TYPE_PROJECT) return '';
        $spring = $this->course * 2;
        $fall = $spring - 1;
        return $this->workSubject->total[$fall - 1] + $this->workSubject->total[$spring - 1];
    }

    /**
     * @return int
     */
    public function getPlanClasses()
    {
        if ($this->type == self::TYPE_PROJECT) return '';
        $spring = $this->course * 2;
        $fall = $spring - 1;
        return $this->workSubject->getClasses($fall - 1) + $this->workSubject->getClasses($spring - 1);
    }

    /**
     * @return int
     */
    public function getPlanSelfWork()
    {
        if ($this->type == self::TYPE_PROJECT) return '';
        $spring = $this->course * 2;
        $fall = $spring - 1;
        return $this->workSubject->getSelfwork($fall - 1) + $this->workSubject->getSelfwork($spring - 1);
    }


    public function validateConsultation()
    {
        if (!$this->hasErrors() && $this->scenario != 'project') {
            $spring = $this->course * 2;
            $fall = $spring - 1;
            if ($this->consult[0] > $this->calcConsultation($fall))
                $this->addError('consult[0]', Yii::t('load', 'Consultations amount exceeds maximum'));
            if ($this->consult[1] > $this->calcConsultation($spring))
                $this->addError('consult[1]', Yii::t('load', 'Consultations amount exceeds maximum'));
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->scenario == 'project' && isset($this->work_subject_id)) {
                $control = $this->workSubject->control;
                for ($i = 0; $i < count($control); $i++) {
                    $students = $this->students[0];
                    if ($control[WorkSubject::CONTROL_PROJECT] || $control[WorkSubject::CONTROL_WORK]) {
                        switch ($this->workType) {
                            case 0:
                                $rate = $this->WORK_RATE;
                                break;
                            case 1:
                                $rate = $this->PROJECT_RATE;
                                break;
                            case 2:
                                $rate = $this->DIPLOMA_RATE;
                                break;
                            default:
                                $rate = $this->WORK_RATE;
                        }
                        $hours = array();
                        $hours[self::HOURS_WORKS] = 0;
                        $hours[self::HOURS_DKK] = 0;
                        $hours[self::HOURS_PROJECT] = $students * $rate[0];
                        $hours[self::HOURS_CHECK] = $students * $rate[1];
                        $hours[self::HOURS_CONTROL] = $students * $rate[2];
                        if ($i & 1) {
                            $this->fall_hours = $hours;
                        } else {
                            $this->spring_hours = $hours;
                        }
                        break;
                    }
                }

            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
            0 => Yii::t('load', 'Course work'),
            1 => Yii::t('load', 'Course project'),
            2 => Yii::t('load', 'Diploma project'),
        ];
    }

    protected function findModel($id)
    {
        if (($model = self::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $group_id
     * @param null $year_id
     * @return static[]
     */
    public static function getArrayByGroupAndYear($group_id, $year_id = null)
    {
        if (is_null($year_id)) {
            $year_id = StudyYear::getCurrentYear()->id;
        }
        if ($year_id == 5 && $group_id == 8) {
            $models = [];
            $models[] = self::getZaglushka();
            return $models;
        }
        return [];
        return self::findAll(['group_id' => $group_id, 'year_id' => $year_id]);
    }

    /**
     * @return string
     */
    public function getSubjectName()
    {
        return $this->workSubject->subject->title;
    }

    /**
     * @return string
     */
    public function getTeacherFullName()
    {
        return $this->employee->getFullName();
    }

    /**
     * @return string
     */
    public function getLabelInfo()
    {
        return
            "<h2>" . Yii::t('app', 'Subject') . ':' . $this->getSubjectName() . '</h2><h3>' . Yii::t('app', 'Teacher ID') . ': ' . $this->getTeacherFullName() . "</h3>";
    }

    /**
     * @param $group_id
     * @param null $year_id
     * @return array
     */
    public static function getListByGroupAndYear($group_id, $year_id = null)
    {
        return ArrayHelper::map(self::getArrayByGroupAndYear($group_id, $year_id), 'id', 'labelInfo');
    }

    public static function getZaglushka()
    {
        WorkSubject::findOne(12);
        $model = new Load();
        $model->id = 228;
        $model->work_subject_id = 3;
        $model->study_year_id = 5;
        $model->group_id = 8;
        $model->employee_id = 1;
        return $model;
    }
}
