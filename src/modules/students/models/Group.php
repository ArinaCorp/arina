<?php

namespace app\modules\students\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\StudyYear;

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
class Group extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%group}}';
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

    /**
     * @return ActiveQuery
     */
    public function getSpecialityQualification()
    {
        return $this->hasOne(SpecialityQualification::className(), ['id' => 'speciality_qualifications_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStudyYear()
    {
        return $this->hasOne(StudyYear::className(), ['id' => 'created_study_year_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getGroupLeader()
    {
        return $this->hasOne(Student::className(), ['id' => 'group_leader_id']);
    }

    /**
     * @return int
     */
    public function getSystemYearPrefix()
    {
        return $this->studyYear->year_start % 100 - $this->specialityQualification->getOffsetYears();
    }

    /**
     * @return string
     */
    public function getSystemTitle()
    {
       //return $this->specialityQualification->speciality->short_title . '-' . $this->getSystemYearPrefix() . $this->number_group;
    }

    /**
     * @return array
     */
    public static function getTreeList()
    {
        $list = [];
        $specialityQualifications = SpecialityQualification::find()->all();
        /**
         * @var SpecialityQualification[] $specialityQualifications
         */
        foreach ($specialityQualifications as $specialityQualification) {
            foreach ($specialityQualification->groups as $group) {
                $list[$specialityQualification->title][$group->id] = $group->title;
            }
        }
        return $list;
    }

    /**
     * @return Student[]
     */
    public function getStudentsArray()
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

    /**
     * @return array
     */
    public function getStudentsList()
    {
        $array = $this->getStudentsArray();
        $result = [];
        foreach ($array as $item) {
            $result[$item->id] = $item->getFullNameAndCode();
        }
        return $result;
    }

    /**
     * @return Student[]
     */
    public function getNotStudentsArray()
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

    /**
     * @param null $yearId
     * @return int
     */
    public function getCourse($yearId = null)
    {
        $year = null;
        if (isset($yearId)) {
            $year = StudyYear::findOne(['id' => $yearId]);
        }
        if (!isset($year)) {
            $year = StudyYear::getCurrentYear();
        }
        $last_year = mb_substr($this->title, 3, 2, 'UTF-8');
        $value = $year->getYearEnd() - 2000 - $last_year;
        return $value;
    }
}
