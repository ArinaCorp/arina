<?php

namespace app\modules\plans\models;

use app\components\ExportToExcel;
use app\modules\directories\models\subject_block\SubjectBlock;
use app\modules\students\models\Group;
use app\modules\students\models\Student;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;

use yii\behaviors\TimestampBehavior;
use nullref\useful\behaviors\JsonBehavior;

use app\modules\directories\models\study_year\StudyYear;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\department\Department;
use app\modules\directories\models\subject\Subject;

/**
 * This is the model class for table "student_plan".
 *
 * The followings are the available columns in table 'student_plan':
 * @property integer $id
 * @property integer $student_id
 * @property integer $group_id
 * @property integer $course
 * @property integer $semester
 * @property integer $work_plan_id
 * @property integer $subject_block_id
 * @property integer $approved_by
 * @property string $created
 * @property string $updated
 *
 * @property Student $student
 * @property WorkPlan $workPlan
 * @property SubjectBlock $subjectBlock
 * @property WorkSubject[] $workSubjects
 * @property User $approvedBy
 * @property string approverFullName
 *
 * @property string $groupTitle
 *
 * @property Group $group
 *
 */
class StudentPlan extends ActiveRecord
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
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
            [['student_id', 'group_id', 'work_plan_id', 'subject_block_id', 'course', 'semester'], 'integer'],
            [['student_id'], 'required'],
        ];
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%student_plan}}';
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => Yii::t('app', 'Student'),
            'work_plan_id' => Yii::t('plans', 'The work plan for the base'),
            'subject_block_id' => Yii::t('app', 'Subject block'),
            'semester' => Yii::t('app', 'Semester'),
            'groupTitle' => Yii::t('app', 'Group'),
            'approved_by' => Yii::t('app', 'Approved by'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::class, ['id' => 'student_id']);
    }

    /**
     * Student's group at the moment of plan's creation.
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }

    /**
     * @return string
     */
    public function getGroupTitle()
    {
        return $this->group->title;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkPlan()
    {
        return $this->hasOne(WorkPlan::class, ['id' => 'work_plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubjectBlock()
    {
        return $this->hasOne(SubjectBlock::class, ['id' => 'subject_block_id']);
    }

    /**
     * Returns all work subjects which are not optional
     * @return WorkSubject[]
     */
    public function getWorkSubjects()
    {
        $subjects = [];
        foreach ($this->workPlan->workSubjects as $workSubject) {
            //TODO: Set a constant for 'ПВС' code
            if (strpos($workSubject->subject->code, 'ПВС') === false)
                $subjects [] = $workSubject;
        }
        return $subjects;
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\InvalidConfigException
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->course = $this->student->currentGroup->getCourse($this->workPlan->study_year_id);
            $this->group_id = $this->student->currentGroup->id;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function getDocument()
    {
        ExportToExcel::getDocument('StudentPlan', $this);
    }

    /**
     * Returns the user that approved the plan.
     * @return \yii\db\ActiveQuery
     */
    public function getApprovedBy()
    {
        return $this->hasOne(User::class, ['id' => 'approved_by']);
    }

    /**
     * Check if the plan is approved.
     * @return bool
     */
    public function isApproved()
    {
        return isset($this->approved_by);
    }

    /**
     * Returns the string of approver's name, if approver has no employee_id returns 'Admin...', if not approved - null.
     * @return string|null
     */
    public function getApproverFullName()
    {
        if ($this->isApproved()) {
            if ($employee = $this->approvedBy->employee) {
                return $employee->fullName;
            }
            return Yii::t('app', 'Administrator');
        }
        return null;
    }

}