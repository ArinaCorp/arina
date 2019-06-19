<?php


namespace app\components\exporters;

use app\components\ExportHelpers;
use app\modules\plans\models\StudyPlan;
use app\modules\plans\models\StudySubject;
use app\modules\plans\models\WorkPlan;
use app\modules\students\models\Group;

use app\modules\students\models\Student;
use codemix\excelexport\ActiveExcelSheet;
use codemix\excelexport\ExcelSheet;
use DateTime;
use PhpOffice\PhpSpreadsheet;
use Yii;
use yii\helpers\ArrayHelper;

class ExportAttestation
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
        $group_id = $data["data"]["group_id"];
        $group = Group::findOne($group_id);
        $students = $group->getStudentsArray();
        $studyPlan_id = $data["data"]["plan_id"];
        $studyPlan = StudyPlan::findOne(['id' => $studyPlan_id]);
        $semester = $data["data"]["semester"];
        $romanSemester = ExportHelpers::ConvertToRoman($data["data"]["semester"]);
        $excel = $spreadsheet->getActiveSheet();
        $passes = ExportHelpers::getPropusk($students);
        $hours_sum = [0, 0];
        $marks_two_three = [];
        $subject_titles = [];
        $avg_marks = [];
        $subjects = [];
        $count = [0, 0, 0];
        $startRow = 8;
        $current = $startRow;
        self::getSubjects($studyPlan, $semester, $subject_titles, $subjects);
        self::insertFormData($spreadsheet, $romanSemester, $data, $group_id);
        self::insertStudents($spreadsheet, $students, $current);
        self::insertSubjectTitles($spreadsheet, $subject_titles);
        self::insertDateAndGroupLeaders($spreadsheet, $current, $group);

        if ($data["data"]['marks_checker']) {
            $marks = ExportHelpers::getMarks($subjects, $students);
            $current = $startRow;
            $letter = self::drawMarks($spreadsheet, $students, $subjects, $marks, $current, $count, $marks_two_three, $avg_marks)['letter'];
            $current = $startRow;
            self::insertPass($spreadsheet,$letter,$current,$students,$passes,$hours_sum);
            $afterMarksLetter = $letter;
            self::insertQualitySuccess($spreadsheet,$letter,$current,$hours_sum);
            $letter = $afterMarksLetter;
            $current++;
            $excel->setCellValue("${letter}${current}", $hours_sum[0] / count($passes));
            $letter++;
            $excel->setCellValue("${letter}${current}", $hours_sum[1] / count($passes));
            $quality = round((count($students) - $count[2]) / count($students) * 100, 2);
            $success_rate = round((count($students) - $count[0]) / count($students) * 100, 2);
            $current += 2;
            $footer_current = $current;
            $excel->setCellValue("I${current}", "Успішність       ${success_rate} %");
            $excel->getStyle("I${current}")->getFont()->setBold(0);
            $current++;
            $excel->setCellValue("I${current}", "Якість       ${quality} %");
            $excel->getStyle("I${current}")->getFont()->setBold(0);
            $marks_sum = [0, 0, 0, 0];
            foreach ($avg_marks as $mark) {
                $marks_sum[0] += ($mark >= 4.5) ? 1 : 0;
                $marks_sum[1] += ($mark >= 3.5 && $mark < 4.5) ? 1 : 0;
                $marks_sum[2] += ($mark >= 2.5 && $mark < 3.5) ? 1 : 0;
                $marks_sum[3] += ($mark < 2.5 && $mark < 3.5) ? 1 : 0;
            }
            $current = $footer_current;
            foreach ($marks_sum as $index => $sum) {
                $excel->setCellValue("B${current}", ExportHelpers::textBetween([ExportHelpers::getMarkLabels()[$index], $sum, "студ."], [45, 5]));
                $excel->getStyle("B${current}")->getAlignment()->setHorizontal('left');
                $current++;
            }
        } else {
            $current += 3;
            $excel->setCellValue("I${current}", "Успішність        %");
            $excel->getStyle("I${current}")->getFont()->setBold(0);
            $current++;
            $excel->setCellValue("I${current}", "Якість        %");
            $excel->getStyle("I${current}")->getFont()->setBold(0);
        }
        return $spreadsheet;
    }

    /**
     * @param $spreadsheet PhpSpreadsheet\Spreadsheet
     * @param $current
     * @param $students
     * @return mixed
     * @throws PhpSpreadsheet\Exception
     */
    public static function insertStudents($spreadsheet, $students, &$current)
    {
        $excel = $spreadsheet->getActiveSheet();
        $i = 1;
        foreach ($students as $student) {
            $excel->insertNewRowBefore($current + 2);
            $excel->setCellValue('A' . $current, $i)->getStyle('A' . $current)->getAlignment()->setHorizontal("center");
            $excel->setCellValue('B' . $current, $student->getFullName());
            if (strcmp($student->getPaymentTypeLabel(), "К") == 0)
                $excel->setCellValue('I' . $current, $student->getPaymentTypeLabel());
            $i++;
            $current++;
        }
        $excel->removeRow($current + 1);
        $excel->removeRow($current);
        $excel->removeRow($current);
    }

    /**
     * @param $spreadsheet PhpSpreadsheet\Spreadsheet
     * @param $romanSemester string
     * @param $data
     * @param $group_id integer
     * @throws PhpSpreadsheet\Exception
     */
    public static function insertFormData($spreadsheet, $romanSemester, $data, $group_id)
    {
        $excel = $spreadsheet->getActiveSheet();
        $excel->setCellValue('A300', $romanSemester);
        $excel->setCellValue('A301', Date('d.m', strtotime($data['data']['dateFrom'])));
        $excel->setCellValue('B301', Date('d.m', strtotime($data['data']['dateTo'])));
        $excel->setCellValue('A302', Group::findOne($group_id)->title);
        $excel->setCellValue('A303', Date('Y', strtotime($data['data']['dateFrom'])));
        $excel->setCellValue('B303', Date('Y', strtotime($data['data']['dateTo'])));
    }

    /**
     * @param $studyPlan StudyPlan
     * @param $semester integer
     * @param $subject_titles string[]
     * @param $subjects StudySubject[]
     */
    public static function getSubjects($studyPlan, $semester, &$subject_titles, &$subjects)
    {
        foreach ($studyPlan->studySubjects as $item) {
            if ($item->weeks[$semester - 1] != 0) {
                array_push($subject_titles, $item->subject->title);
                array_push($subjects, ['subject' => $item->subject]);
            }
        }
    }

    /**
     * @param $spreadsheet PhpSpreadsheet\Spreadsheet
     * @param $subject_titles string[]
     * @throws PhpSpreadsheet\Exception
     */
    public static function insertSubjectTitles($spreadsheet, $subject_titles)
    {
        $excel = $spreadsheet->getActiveSheet();
        foreach ($subject_titles as $subject_title) {
            $excel->setCellValue("D7", $subject_title);
            $excel->getColumnDimension('D')->setWidth(4);
            $excel->insertNewColumnBefore("D", 1);
        }
        $excel->removeColumn("C");
        $excel->removeColumn("C");
        $excel->setCellValue("C5", Yii::t("app", "Subject title"));
    }

    /**
     * @param $spreadsheet PhpSpreadsheet\Spreadsheet
     * @param $current integer
     * @param $group Group
     * @throws PhpSpreadsheet\Exception
     */
    public static function insertDateAndGroupLeaders($spreadsheet, &$current, $group)
    {
        $excel = $spreadsheet->getActiveSheet();
        $excel->setCellValue('G' . ($current + 7), Yii::t('app', 'Curator') . "________/" . $group->getCuratorShortNameInitialFirst() . "/");
        $excel->getStyle('G' . ($current + 7))->getFont()->setBold(0)->setSize(12);
        $excel->setCellValue('G' . ($current + 8), Yii::t('app', 'Student') . "________/" . $group->getGroupLeaderShortNameInitialFirst() . "/");
        $excel->getStyle('G' . ($current + 8))->getFont()->setBold(0)->setSize(12);
        $excel->setCellValue('B' . ($current + 8), Yii::t('app', 'Date') . ": " . date('d.m.Y') . "  " . Yii::t('app', 'Time') . ": " . date('H:i:s'));

    }

    /**
     * @param $spreadsheet PhpSpreadsheet\Spreadsheet
     * @param $students Student[]
     * @param $subjects StudySubject[]
     * @param $marks
     * @param $current integer
     * @param $count integer[]
     * @param $marks_two_three
     * @param $avg_marks
     * @return array
     * @throws PhpSpreadsheet\Exception
     */
    public static function drawMarks($spreadsheet, $students, $subjects, $marks, &$current, &$count, &$marks_two_three, &$avg_marks)
    {
        $letter = 'C';
        $excel = $spreadsheet->getActiveSheet();
        foreach ($students as $student) {
            $letter = 'C';
            $marks_sum = 0;
            foreach ($subjects as $subject) {
                foreach ($marks as $mark) {
                    if ($mark["student_id"] == $student->id && $mark["subject_id"] == $subject['subject']->id) {
                        $cords = "${letter}${current}";
                        $excel->setCellValue($cords, $mark["value"]);
                        $marks_sum += $mark["value"];
                        ExportHelpers::MarkColorized($spreadsheet, $mark["value"], $cords);
                        array_push($marks_two_three, $mark["value"]);
                    }
                }
                $letter++;
            }
            self::countQualitySuccess($marks_two_three, $count);
            $marks_two_three = [];
            $avg = $marks_sum / count($subjects);
            array_push($avg_marks, $avg);
            $excel->setCellValue("${letter}${current}", $avg);
            $current++;
        }
        return ['letter' => $letter];
    }

    public static function countQualitySuccess($marks_two_three, &$count)
    {
        $count[0] += array_filter($marks_two_three, function ($num) {
            return (int)$num < 2.5;
        }) ? 1 : 0;
        $count[1] += array_filter($marks_two_three, function ($num) {
            return (int)$num >= 2.5 && $num < 3.5;
        }) ? 1 : 0;
        $count[2] += array_filter($marks_two_three, function ($num) {
            return (int)$num < 3.5;
        }) ? 1 : 0;
    }

    /**
     * @param $spreadsheet PhpSpreadsheet\Spreadsheet
     * @param $letter string
     * @param $current integer
     * @param $students Student[]
     * @param $passes
     * @param $hours_sum integer[]
     * @throws PhpSpreadsheet\Exception
     */
    public static function insertPass($spreadsheet, &$letter, &$current, $students, $passes, &$hours_sum)
    {
        $excel = $spreadsheet->getActiveSheet();
        foreach ($students as $student) {
            $l = $letter;
            $current_pass = $passes[array_search($student->id, array_column($passes, "student_id"))];
            $hours_sum[0] += $current_pass["hours"];
            $hours_sum[1] += $current_pass["with_reason"];
            $l++;
            $excel->setCellValue("${l}${current}", $current_pass["hours"]);
            $l++;
            $excel->setCellValue("${l}${current}", $current_pass["with_reason"]);
            $current++;
        }
        $letter++;
    }

    /**
     * @param $spreadsheet PhpSpreadsheet\Spreadsheet
     * @param $letter string
     * @param $current integer
     * @param $hours_sum integer[]
     * @throws PhpSpreadsheet\Exception
     */
    public static function insertQualitySuccess($spreadsheet,&$letter,&$current,&$hours_sum)
    {
        $excel = $spreadsheet->getActiveSheet();
        $excel->setCellValue("${letter}${current}", $hours_sum[0]);
        $letter++;
        $excel->setCellValue("${letter}${current}", $hours_sum[1]);
    }

}