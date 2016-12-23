<?php

namespace app\modules\students\models;

use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\StudyYear;
use Yii;
use yii\helpers\ArrayHelper;
use PHPExcel;
use PHPExcel_IOFactory;

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
 *
 * @property SpecialityQualification $specialityQualification
 * @property Student $groupLeader
 * @property StudyYear $studyYear;
 *
 * @property boolean $active;
 */
class Group extends \yii\db\ActiveRecord
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
            'systemTitle' => Yii::t('app', 'System title'),
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
        $students = Student::find()->all();
        foreach ($students as $student) {
            $idsGroup = $student->getGroupArray();
            if (!is_null($idsGroup)) {
                if (array_key_exists($this->id, $idsGroup)) {
                    $student->payment_type = $idsGroup[$this->id];
                    array_push($result, $student);
                };
            }
        }

        return $result;
    }

    public
    function getStudentsList($data = null)
    {
        $array = $this->getStudentsArray($data);
        $result = [];
        foreach ($array as $item) {
            $result[$item->id] = $item->getFullNameAndCode();
        }
        return $result;
    }

    public
    function getNotStudentsArray($data = null)
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

    public
    static function getActiveGroups()
    {
        /**
         * @var Group[] $groups
         */
        $groups = self::find()->all();
        foreach ($groups as $key => $group) {
            if ($group->active) {
                unset($groups[$key]);
            }
        }
        return $groups;
    }

    public
    static function getAllGroups()
    {
        return self::find()->all();
    }

    public
    static function getActiveGroupsList()
    {
        return ArrayHelper::map(self::getActiveGroups(), 'id', 'title');
    }

    public
    static function getAllGroupsList()
    {
        return ArrayHelper::map(self::getAllGroups(), 'id', 'title');
    }

    public
    function getActive()
    {
        return $this->specialityQualification->getCountCourses() < (StudyYear::getCurrent()->year_start - $this->studyYear->year_start);
    }

    public
    function getCoursesList()
    {
        $count = $this->specialityQualification->getCountCourses();
        $data = [];
        for ($i = 0; $i < $count; $i++) {
            $data[$i + 1] = $i + 1;
        }
        return $data;
    }

    public
    static function getTitleById($id)
    {
        return self::find()->where(['id' => $id])->one()->title;
    }

    public
    static function getRelatedGroupById($id)
    {
        $current = Group::findOne(['id' => $id]);
        $all = Group::find()->where(
            [
                'created_study_year_id' => $current->created_study_year_id,
                'speciality_qualification_id' => $current->speciality_qualifications_id,
            ])->all();
        foreach ($all as $key => $item) {
            if ($item->id == $id) unset($all[$key]);
        }
        return $all;
    }


    public
    static function getRelatedGroupListById($id)
    {
        return ArrayHelper::map(self::getRelatedGroupById($id), 'id', 'title');
    }

    public
    function getGroupLeaderFullName()
    {
        return (is_null($this->group_leader_id)) ? Yii::t('app', 'No select') : $this->groupLeader->getFullName();
    }

    public function getDocument()
    {

        $tmpfname = Yii::getAlias('@webroot') . "/templates/group.xls";
        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);;
        $excelObj = $excelReader->load($tmpfname);
        $excelObj->setActiveSheetIndex(0);
        $excelObj->getActiveSheet()->SetCellValue('B2', $this->title);
        /**
         * @var Student[] $students
         */
        $students = $this->getStudentsArray();
        if (!is_null($students)) {
            $startRow = 4;
            $current = $startRow;
            $i = 1;
            foreach ($students as $student) {
                $excelObj->getActiveSheet()->SetCellValue('A' . $current, $i);
                $excelObj->getActiveSheet()->SetCellValue('B' . $current, $student->getFullName());
                $i++;
                $current++;
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        $filename = "Group_" . $this->title . "_" . date("d-m-Y-His") . ".xls";
        header('Content-Disposition: attachment;filename=' . $filename . ' ');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($excelObj, 'Excel2007');
        $objWriter->save('php://output');
    }
}
