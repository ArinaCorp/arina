<?php


namespace app\components\exporters;

use app\modules\directories\models\subject\Subject;
use app\modules\employee\models\Employee;
use app\modules\employee\models\Teacher;
use app\modules\plans\models\StudyPlan;
use app\modules\students\models\Group;
use app\modules\students\models\Student;
use DateTime;
use Mpdf\Tag\Em;
use PhpOffice\PhpSpreadsheet;
use Yii;
use app\components\ExportHelpers;

class ExportZalik
{
    /**
     *
     * @param $spreadsheet PhpSpreadsheet\Spreadsheet
     * @param $data
     * @return PhpSpreadsheet\Spreadsheet
     * @throws PhpSpreadsheet\Exception
     */
    public static function getSpreadsheet($spreadsheet,$data)
    {
        $spreadsheet->setActiveSheetIndex(0);
        $cursor = $spreadsheet->getActiveSheet();
        $subject = Subject::findOne(['id'=>$data["data"]["subject_id"]])->title;
        $specialnist = Group::findOne(['id'=>$data["data"]["group_id"]])->specialityQualification->speciality->title;
        $semester = ExportHelpers::ConvertToRoman($data["data"]["semester"]);
        $cours = $data["data"]["course"];
        $group = Group::findOne(['id'=>$data["data"]["group_id"]])->title;
        $studyPlan_id = $data["data"]["plan_id"];
        $studyPlan = StudyPlan::findOne(['id' => $studyPlan_id]);

        /**
         * @var $teachers Employee
         */
        $teachers = Employee::findAll($data["data"]["teachers_id"]);
        $teachers_list = [];
        foreach ($teachers as $teacher){
            array_push($teachers_list,$teacher->getFullName());
        }

        $teachers = join($teachers_list,", ");

        $cursor->setCellValue("J101",$subject);
        $cursor->setCellValue("J102",$specialnist);
        $cursor->setCellValue("J103",$semester);
        $cursor->setCellValue("J104",$cours);
        $cursor->setCellValue("J105",$group);
        $cursor->setCellValue("J106",$teachers);

        $id = $data["data"]["group_id"];
        $group = Group::findOne($id);
        $students = $group->getStudentsArray();

        $current = 19;
        $i = 1;
        foreach ($students as $student) {
            $cursor->insertNewRowBefore($current+1);
            $cursor->mergeCells("B${current}:E${current}");
            $cursor->mergeCells("F${current}:G${current}");
            $cursor->setCellValue("A${current}", $i);

            $cursor->setCellValue('B' . $current, $student->getFullName());
            $i++;
            $current++;
        }
        $cursor->removeRow($current);
        $cursor->removeRow($current);
        $cursor->setCellValue('C' . ($current + 8), Yii::t('app', 'Date') . ": " . date('d.m.Y') . "  " . Yii::t('app', 'Time') . ": " . date('H:i:s'));

        return $spreadsheet;
    }



}