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

class ExportExam
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
        $subject = Subject::findOne(['id'=>$data["data"]["subject_id"]]);
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

        $cursor->setCellValue("K101",$subject->title);
        $cursor->setCellValue("K102",$specialnist);
        $cursor->setCellValue("K103",$semester);
        $cursor->setCellValue("K104",$cours);
        $cursor->setCellValue("K105",$group);
        $cursor->setCellValue("K106",$teachers);

        $id = $data["data"]["group_id"];
        $group = Group::findOne($id);
        $students = $group->getStudentsArray();
        $failed_students = 0;
        $avg = 0;
        $subjects = [$subject];
        $student_mark = ExportHelpers::getMarks($subjects, $students);
        $tickets = ExportHelpers::getTickets(count($students));
        $current = 19;
        $i = 1;
        foreach ($students as $index=>$student) {
            $cursor->insertNewRowBefore($current+1);
            $cursor->mergeCells("B${current}:E${current}");
            $cursor->mergeCells("G${current}:H${current}");
            $mark = $student_mark[array_search($student->id, array_column($student_mark, "student_id"))];
            $avg += $mark['value'];
            $failed_students += $mark['value'] < 3.5 ? 1 : 0;
            $cursor->setCellValue("F${current}", $tickets[$index])->getStyle("F${current}")->getAlignment()->setHorizontal('center');
            $cursor->setCellValue("G${current}", $mark['value']);
            $cursor->setCellValue("A${current}", $i);

            $cursor->setCellValue('B' . $current, $student->getFullName());
            $i++;
            $current++;
        }
        $cursor->removeRow($current);
        $cursor->removeRow($current);
        $cursor->setCellValue("G${current}", round($avg / count($student_mark),2));
        $quality = round((count($students) - $failed_students) / count($students) * 100, 2);
        $current+=3;
        $footer_current = $current;
        $cursor->setCellValue("I${current}", "${quality} %");
        $current++;
        $cursor->setCellValue("I${current}", "${quality} %");
        $marks_sum = [0, 0, 0, 0];
        $marks = array_map(function($item){return $item["value"];},$student_mark);
        foreach ($marks as $mark) {
            $marks_sum[0] += ($mark >= 4.5) ? 1 : 0;
            $marks_sum[1] += ($mark >= 3.5 && $mark < 4.5) ? 1 : 0;
            $marks_sum[2] += ($mark >= 2.5 && $mark < 3.5) ? 1 : 0;
            $marks_sum[3] += ($mark < 2.5 && $mark < 3.5) ? 1 : 0;
        }
        $current = $footer_current;
        foreach ($marks_sum as $index => $sum) {
            $cursor->setCellValue("B${current}", ExportHelpers::textBetween([ExportHelpers::getMarkLabels()[$index], $sum,"студ."], [40,5]));
            $cursor->getStyle("B${current}")->getAlignment()->setHorizontal('left');
            $current++;
        }
        $cursor->setCellValue('C' . ($current + 3), Yii::t('app', 'Date') . ": " . date('d.m.Y') . "  " . Yii::t('app', 'Time') . ": " . date('H:i:s'));

        return $spreadsheet;
    }



}