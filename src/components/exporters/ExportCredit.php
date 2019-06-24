<?php


namespace app\components\exporters;

use app\modules\directories\models\study_year\StudyYear;
use app\modules\directories\models\subject\Subject;
use app\modules\employee\models\Employee;
use app\modules\journal\models\record\JournalMark;
use app\modules\journal\models\record\JournalRecord;
use app\modules\plans\models\StudySubject;
use app\modules\students\models\Group;
use PhpOffice\PhpSpreadsheet;
use Yii;
use app\components\ExportHelpers;

class ExportCredit
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
        $years = StudyYear::findOne(['id' => $data["data"]["years_id"]]);
        $journal_record = JournalRecord::findOne(['id' => $data["data"]["journal_record_id"]]);
        $subject = Subject::findOne(['id' => $data["data"]["subject_id"]]);
        $speciality = Group::findOne(['id' => $data["data"]["group_id"]])->specialityQualification->speciality->title;
        $roman = ExportHelpers::ConvertToRoman(1);
        $semester = 1;
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

        $cursor->setCellValue("J101", $subject->title);
        $cursor->setCellValue("J102", $speciality);
        $cursor->setCellValue("J103", $roman);
        $cursor->setCellValue("J104", $semester);
        $cursor->setCellValue("J105", $group);
        $cursor->setCellValue("J106", $teachers);

        $id = $data["data"]["group_id"];
        $group = Group::findOne($id);
        $students = $group->getStudentsArray();
        $failed_students = 0;
        $avg = 0;
        $marks = NULL;
        if ($data["data"]['marks_checker']) {
            $marks = JournalMark::findAll(['record_id'=>$journal_record->id]);
        }
        $marks_two_three = [];
        $count = [0, 0, 0];
        $current = 19;
        $i = 1;
        foreach ($students as $student) {
            $cursor->insertNewRowBefore($current + 1);
            $cursor->mergeCells("B${current}:E${current}");
            $cursor->mergeCells("F${current}:G${current}");

            $cursor->setCellValue("A${current}", $i);
            $cursor->setCellValue('B' . $current, $student->getFullName());
            if (!empty($marks)) {
                $mark = $marks[array_search($student->id, array_column($marks, "student_id"))];
                $avg += $mark->value;
                $failed_students += $mark->value < 3.5 ? 1 : 0;
                $cursor->setCellValue("F${current}", $mark->value);
                array_push($marks_two_three, $mark->value);
            }
            $i++;
            $current++;
            $count[0] += array_filter($marks_two_three, function ($num) {
                return (int)$num < 2.5;
            }) ? 1 : 0;
            $count[1] += array_filter($marks_two_three, function ($num) {
                return (int)$num >= 2.5 && $num < 3.5;
            }) ? 1 : 0;
            $count[2] += array_filter($marks_two_three, function ($num) {
                return (int)$num < 3.5;
            }) ? 1 : 0;
            $marks_two_three = [];
        }
        $cursor->removeRow($current);
        $cursor->removeRow($current);
        $cursor->setCellValue("F${current}", count($marks) != 0 ? (round($avg / count($marks), 2)) : "");
        $quality = count($marks) != 0 ? (round((count($students) - $count[2]) / count($marks) * 100, 2)) : "  ";
        $success_rate = count($marks) != 0 ? (round((count($students) - $count[0]) / count($marks) * 100, 2)) : "  ";;
        $current += 2;
        $footer_current = $current;
        $cursor->setCellValue("H${current}", "${success_rate} %");
        $current++;
        $cursor->setCellValue("H${current}", "${quality} %");
        $marks_sum = [0, 0, 0, 0];
        $marks = array_map(function ($item) {
            return $item->value;
        }, $marks);
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
        $cursor->setCellValue('C' . ($current + 2), Yii::t('app', 'Date') . ": " . date('d.m.Y') . "  " . Yii::t('app', 'Time') . ": " . date('H:i:s'));

        return $spreadsheet;
    }


}