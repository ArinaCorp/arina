<?php

namespace app\modules\plans\models;

use app\components\ExportToExcel;
use app\modules\directories\models\subject_block\SubjectBlock;
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

use app\modules\directories\models\StudyYear;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\department\Department;
use app\modules\directories\models\subject\Subject;

/**
 * This is the model class for table "student_plan".
 *
 * The followings are the available columns in table 'student_plan':
 * @property integer $id
 * @property integer $student_id
 * @property integer $course
 * @property integer $work_plan_id
 * @property integer $subject_block_id
 * @property string $created
 * @property string $updated
 *
 * @property Student $student
 * @property WorkPlan $workPlan
 * @property SubjectBlock $subjectBlock
 *
 */
class StudentPlan extends ActiveRecord
{

    public $loadSubjectBlock;
    public $loadSubBlockSelect;

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
                'value' => date('Y-m-d H:i:s'),
            ]
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['loadSubBlockSelect', 'loadSubjectBlock'], 'boolean'],
            [['student_id', 'work_plan_id', 'subject_block_id', 'course'], 'integer'],
            [['student_id', 'work_plan_id'], 'required'],
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
     * @return WorkSubject[]
     */
    public function getWorkSubjectsBlock()
    {
        $subjects = [];
        foreach($this->subjectBlock->subjects as $subject){
            foreach($this->workPlan->workSubjects as $workSubject){
                if($workSubject->subject_id == $subject->id)
                $subjects [] = $workSubject;
            }
        }
        return $subjects;
    }

    public function loadsSubjectBlock()
    {
        if ($this->loadSubjectBlock) {
            $this->loadSubjectBlock = false;
            return true;
        }
        return false;
    }

    public function loadsSubBlockSelect()
    {
        if ($this->loadSubBlockSelect) {
            $this->loadSubBlockSelect = false;
            return true;
        }
        return false;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->course = $this->student->course;
            return true;
        } else {
            return false;
        }
    }


}