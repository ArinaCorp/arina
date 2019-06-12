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
    public static function getSpreadsheet($spreadsheet, $data)
    {
        $spreadsheet->setActiveSheetIndex(0);
        $cursor = $spreadsheet->getActiveSheet();
        $subject = Subject::findOne(['id' => $data["data"]["subject_id"]]);
        $specialnist = Group::findOne(['id' => $data["data"]["group_id"]])->specialityQualification->speciality->title;
        $semester = ExportHelpers::ConvertToRoman($data["data"]["semester"]);
        $group = Group::findOne(['id' => $data["data"]["group_id"]])->title;

        /**
         * @var $teachers Employee
         */
        $teachers = Employee::findAll($data["data"]["teachers_id"]);
        $teachers_list = [];
        foreach ($teachers as $teacher) {
            array_push($teachers_list, $teacher->getFullName());
        }

        $teachers = join($teachers_list, ", ");

        $cursor->setCellValue("K101", $subject->title);
        $cursor->setCellValue("K102", $specialnist);
        $cursor->setCellValue("K103", $semester);
        $cursor->setCellValue("K104", round($data["data"]["semester"]/2));
        $cursor->setCellValue("K105", $group);
        $cursor->setCellValue("K106", $teachers);

        $id = $data["data"]["group_id"];
        $group = Group::findOne($id);
        $students = $group->getStudentsArray();
        $failed_students = 0;
        $avg = 0;
        $subjects = [$subject];
        $student_mark = [];
        $tickets = [];
        if ($data["data"]['marks_checker']) {
            $student_mark = ExportHelpers::getMarks($subjects, $students);
            $tickets = ExportHelpers::getTickets(count($students));
        }
        $student_marks_two_three = [];
        $count = [0, 0, 0];
        $current = 19;
        $i = 1;
        foreach ($students as $index => $student) {
            $cursor->insertNewRowBefore($current + 1);
            $cursor->mergeCells("B${current}:E${current}");
            $cursor->mergeCells("G${current}:H${current}");
            $cursor->setCellValue("A${current}", $i);
            $cursor->setCellValue('B' . $current, $student->getFullName());
            if (!empty($student_mark)) {
                $mark = $student_mark[array_search($student->id, array_column($student_mark, "student_id"))];
                $avg += $mark['value'];
                $failed_students += $mark['value'] < 3.5 ? 1 : 0;
                $cursor->setCellValue("F${current}", $tickets[$index])->getStyle("F${current}")->getAlignment()->setHorizontal('center');
                $cursor->setCellValue("G${current}", $mark['value']);
                array_push($student_marks_two_three, $mark["value"]);
            }
            $i++;
            $current++;
            $count[0] += array_filter($student_marks_two_three, function ($num) {
                return (int)$num < 2.5;
            }) ? 1 : 0;
            $count[1] += array_filter($student_marks_two_three, function ($num) {
                return (int)$num >= 2.5 && $num < 3.5;
            }) ? 1 : 0;
            $count[2] += array_filter($student_marks_two_three, function ($num) {
                return (int)$num < 3.5;
            }) ? 1 : 0;
            $student_marks_two_three = [];
        }

        $cursor->removeRow($current);
        $cursor->removeRow($current);
        $cursor->setCellValue("F${current}", count($student_mark) != 0 ? (round($avg /  count($student_mark), 2)):"");
        $quality = count($student_mark) != 0 ? (round((count($students) - $count[2]) / count($student_mark) * 100, 2)) : "  ";
        $success_rate = count($student_mark) != 0 ? (round((count($students) - $count[0]) / count($student_mark) * 100, 2)) : "  ";;
        $current += 3;
        $footer_current = $current;
        $cursor->setCellValue("I${current}", "${success_rate} %");
        $current++;
        $cursor->setCellValue("I${current}", "${quality} %");
        $marks_sum = [0, 0, 0, 0];
        $marks = array_map(function ($item) {
            return $item["value"];
        }, $student_mark);
        foreach ($marks as $mark) {
            $marks_sum[0] += ($mark >= 4.5) ? 1 : 0;
            $marks_sum[1] += ($mark >= 3.5 && $mark < 4.5) ? 1 : 0;
            $marks_sum[2] += ($mark >= 2.5 && $mark < 3.5) ? 1 : 0;
            $marks_sum[3] += ($mark < 2.5 && $mark < 3.5) ? 1 : 0;
        }
        $current = $footer_current;
        foreach ($marks_sum as $index => $sum) {
            $cursor->setCellValue("B${current}", ExportHelpers::textBetween([ExportHelpers::getMarkLabels()[$index], $sum, "студ."], [40, 5]));
            $cursor->getStyle("B${current}")->getAlignment()->setHorizontal('left');
            $current++;
        }
        $cursor->setCellValue('C' . ($current + 3), Yii::t('app', 'Date') . ": " . date('d.m.Y') . "  " . Yii::t('app', 'Time') . ": " . date('H:i:s'));

        return $spreadsheet;
    }


}