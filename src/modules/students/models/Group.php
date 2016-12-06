<?php

namespace app\modules\students\models;

use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\StudyYear;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "group".
 *
 * @property integer $id
 * @property integer $speciality_qualifications_id
 * @property integer $created_study_year_id
 * @property integer $number_group
 * @property string $title
 * @property integer $group_leader_id
 *
 *
 * @property SpecialityQualification $specialityQualification
 * @property Student $groupLeader
 * @property StudyYear $studyYear;
 *
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['speciality_qualifications_id', 'created_study_year_id', 'number_group', 'group_leader_id'], 'integer'],
            [['title'], 'string', 'max' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'speciality_qualifications_id' => Yii::t('app', 'Speciality Qualifications ID'),
            'created_study_year_id' => Yii::t('app', 'Created Study Year ID'),
            'number_group' => Yii::t('app', 'Number Group'),
            'title' => Yii::t('app', 'Title'),
            'group_leader_id' => Yii::t('app', 'Group Leader ID'),
        ];
    }

    public function getSpecialityQualification()
    {
        return $this->hasOne(SpecialityQualification::className(), ['id' => 'speciality_qualifications_id']);
    }

    public function getStudyYear()
    {
        return $this->hasOne(StudyYear::className(), ['id' => 'created_study_year_id']);
    }

    public function getGroupLeader()
    {
        return $this->hasOne(Student::className(), ['id' => 'group_leader_id']);
    }

    public function getSystemYearPrefix()
    {
        return $this->studyYear->year_start % 100 - $this->specialityQualification->getOffsetYears();
    }

    public function getSystemTitle()
    {
        return $this->specialityQualification->speciality->short_title . '-' . $this->getSystemYearPrefix() . $this->number_group;
    }

    public static function getTreeList()
    {
        $list = [];
        $specialityQulifications = SpecialityQualification::find()->all();
        /**
         * @var SpecialityQualification[] $specialityQulifications
         */
        foreach ($specialityQulifications as $specialityQulification) {
            foreach ($specialityQulification->groups as $group) {
                $list[$specialityQulification->title][$group->id] = $group->title;
            }
        }
        return $list;
    }

    public function getStudentsArray($data = null)
    {
        /**
         * @var $result Student[];
         * @var $students Student[];
         */
        $result = [];
        $students = Student::find()->orderBy(['last_name' => SORT_ASC, 'first_name' => SORT_ASC, 'middle_name' => SORT_ASC])->all();
        foreach ($students as $student) {
            $idsGroup = $student->getGroupArray();
            if (in_array($this->id, $idsGroup)) array_push($result, $student);
        }
        return $result;
    }

    public function getStudentsList($data = null)
    {
        $array = $this->getStudentsArray($data);
        $result = [];
        foreach ($array as $item) {
            $result[$item->id] = $item->getFullNameAndCode();
        }
        return $result;
    }

    public function getNotStudentsArray($data = null)
    {
        /**
         * @var $result Student[];
         * @var $students Student[];
         */
        $result = [];
        $students = Student::find()->all();
        foreach ($students as $student) {
            $idsGroup = $student->getGroupArray();
            if (!in_array($this->id, $idsGroup)) array_push($result, $student);
        }
        return $result;
    }
}
