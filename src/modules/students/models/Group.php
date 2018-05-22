<?php

namespace app\modules\students\models;

use app\components\ExportToExcel;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\StudyYear;
use app\modules\employee\models\Employee;
use Yii;
use yii\bootstrap\Html;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

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
    private $_students = [];

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
            'curator_id' => Yii::t('app', 'Curator ID')
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
        return $this->specialityQualification->speciality->short_title . '-' . $this->getSystemYearPrefix() . $this->number_group;
    }


    public function getCountByPayment($payment)
    {
        $count = 0;
        foreach ($this->getStudentsArray() as $student) {
            if ($student->payment_type == $payment) {
                $count++;
            }
        }
        return $count;
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
        if (empty($this->_students)) {
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
            $this->_students = $result;
        }
        return $this->_students;
    }

    public function getStudentsIds()
    {
        return ArrayHelper::getColumn($this->getStudentsArray(), 'id');
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

    public static function getActiveGroups()
    {
        /** @var Group[] $groups */
        $groups = self::find()->all();
        foreach ($groups as $key => $group) {
            if ($group->isActive()) {
                unset($groups[$key]);
            }
        }
        return $groups;
    }

    public static function getAllGroups()
    {
        return self::find()->all();
    }

    public static function getActiveGroupsList()
    {
        return ArrayHelper::map(self::getActiveGroups(), 'id', 'title');
    }

    public static function getAllGroupsList()
    {
        return ArrayHelper::map(self::getAllGroups(), 'id', 'title');
    }

    /**
     * @param bool $year_id
     * @return bool
     */
    public function isActive($year_id = true)
    {
        if ($year_id) {
            $year = StudyYear::findOne($year_id);
        } else {
            $year = StudyYear::findOne(['active' => 1]);
        }
        if ($year->year_start < $this->studyYear->year_start) {
            return false;
        }
        return $this->specialityQualification->getCountCourses() > ($year->year_start - $this->studyYear->year_start);
    }

    public function getCoursesList()
    {
        $count = $this->specialityQualification->getCountCourses();
        $data = [];
        for ($i = 0; $i < $count; $i++) {
            $data[$i + 1] = $i + 1;
        }
        return $data;
    }

    public static function getTitleById($id)
    {
        return self::find()->where(['id' => $id])->one()->title;
    }

    public static function getRelatedGroupById($id)
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


    public static function getRelatedGroupListById($id)
    {
        return ArrayHelper::map(self::getRelatedGroupById($id), 'id', 'title');
    }

    public function getGroupLeaderFullName()
    {
        return (is_null($this->group_leader_id)) ? Yii::t('app', 'Not assigned') : $this->groupLeader->getFullName();
    }

    public function getCuratorFullName()
    {
        return ($this->getCuratorId() === false) ? Yii::t('app', 'Not assigned') : $this->getCurator()->getFullName();
    }

    public function getGroupLeaderShortNameInitialFirst()
    {
        return (is_null($this->group_leader_id)) ? Yii::t('app', 'Not assigned') : $this->groupLeader->getShortNameInitialFirst();
    }

    public function getCuratorShortNameInitialFirst()
    {
        return ($this->getCuratorId() === false) ? Yii::t('app', 'Not assigned') : $this->getCurator()->getShortNameInitialFirst();
    }

    public function getGroupLeaderLink()
    {
        if (!$this->groupLeader) return Yii::t('app', 'Not assigned');
        return $this->groupLeader->getLink();
    }

//    /**
//     * @throws \PHPExcel_Exception
//     * @throws \PHPExcel_Reader_Exception
//     * @throws \PHPExcel_Writer_Exception
//     *
//     * @TODO move to excel export component
//     */
    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function getDocument()
    {
//        $tmpfname = Yii::getAlias('@webroot') . "/templates/group.xls";
//        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);;
//        $excelObj = $excelReader->load($tmpfname);
//        $excelObj->setActiveSheetIndex(0);
//        $excelObj->getActiveSheet()->SetCellValue('B2', $this->title);
//        $excelObj->getActiveSheet()->SetCellValue('B3', StudyYear::getCurrentYear()->fullName . " навчального року");
//        /**
//         * @var Student[] $students
//         */
//        $students = $this->getStudentsArray();
//        if (!is_null($students)) {
//            $startRow = 7;
//            $current = $startRow;
//            $i = 1;
//            foreach ($students as $student) {
//                $excelObj->getActiveSheet()->mergeCells("C" . $current . ":G" . $current);
//                $excelObj->getActiveSheet()->insertNewRowBefore($current + 1);
//                $excelObj->getActiveSheet()->setCellValue('B' . $current, $i);
//                $excelObj->getActiveSheet()->setCellValue('C' . $current, $student->getFullName());
//                $excelObj->getActiveSheet()->setCellValue('H' . $current, $student->getPaymentTypeLabel());
//                $i++;
//                $current++;
//            }
//            $excelObj->getActiveSheet()->removeRow($current);
//            $excelObj->getActiveSheet()->removeRow($current);
//            $current += 1;
//            $excelObj->getActiveSheet()->setCellValue('F' . $current, $this->getCuratorShortNameInitialFirst());
//            $current += 2;
//            $excelObj->getActiveSheet()->setCellValue('F' . $current, $this->getGroupLeaderShortNameInitialFirst());
//            $current += 2;
//            $excelObj->getActiveSheet()->setCellValue('F' . $current, Yii::t('app', 'Date created'));
//            $excelObj->getActiveSheet()->setCellValue('G' . $current, date('d.m.Y H:i:s'));
//        }
//        header('Content-Type: application/vnd.ms-excel');
//        $filename = "Group_" . $this->title . "_" . date("d-m-Y-His") . ".xls";
//        header('Content-Disposition: attachment;filename=' . $filename . ' ');
//        header('Cache-Control: max-age=0');
//        $objWriter = PHPExcel_IOFactory::createWriter($excelObj, 'Excel2007');
//        $objWriter->save('php://output');
        ExportToExcel::getDocument('Group',$this);
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
        $value = $year->getYearEnd() - $this->studyYear->year_start;
        return $value;
    }

    /**
     * @return bool|int
     */
    public function getCuratorId()
    {
        $teachers = Employee::getAllTeacher();
        if ($teachers) {
            foreach ($teachers as $teacher) {
                /**
                 * @var $teacher Employee;
                 */
                if (in_array($this->id, $teacher->getGroupArray())) {
                    return $teacher->id;
                }
            }
        }
        return false;
    }

    /**
     * @return array|null|Employee
     */

    public function getCurator()
    {
        return Employee::find()->where(['id' => $this->getCuratorId()])->one();
    }

    public function getCuratorLink()
    {
        if ($this->getCuratorId() === false) return Yii::t('app', 'Not assigned');
        return $this->getCurator()->getLink();
    }


    public function getTitleAndLink()
    {
        return Html::a($this->title, Url::to(['/students/group/view', 'id' => $this->id]));
    }

}
