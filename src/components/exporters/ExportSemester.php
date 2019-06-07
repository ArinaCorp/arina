<?php


namespace app\components\exporters;

use app\components\ExportHelpers;
use app\modules\directories\models\subject\Subject;
use app\modules\plans\models\StudyPlan;
use app\modules\students\models\Group;
use PhpOffice\PhpSpreadsheet;
use Yii;

class ExportSemester
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
        $semester = $data["data"]["semester"];
        $group = Group::findOne(['id' => $data["data"]["group_id"]]);
        $year = $data["data"]["date"];
        $year = $year . "/" . ($year + 1);

        $subjects = [];
        $zalikSubjects = [];
        $courseSubject = [];
        $exhamSubjects = [];
        $dpaSubjects = [];

        $studyPlan_id = $data["data"]["plan_id"];
        $studyPlan = StudyPlan::findOne(['id' => $studyPlan_id]);
        $romanSemester = ExportHelpers::ConvertToRoman($semester);
        $students = $group->getStudentsArray();
        $current = 9;
        $i = 1;
        $beforeRow = null;
        $failed_students = [];
        $pass = ExportHelpers::getPropusk($students);
        $hours_sum = [0, 0];
        $pass_row_start_letter = "";
        $avg_marks = [];
        $footer_current = 0;
        $avg_avg = 0;
        $marks_column_begin = "D";

        $subjectCounter = ExportHelpers::coundLengthOfMultipleArrays([$zalikSubjects, $courseSubject, $exhamSubjects, $dpaSubjects]);
        if ($subjectCounter == 0) {
            foreach ($studyPlan->studySubjects as $item) {
                if ($item->weeks[$semester - 1] != 0) {
                    //      Zalik
                    if ($item->control[$semester - 1][0] == true) {
                        array_push($zalikSubjects, $item->subject);
                        array_push($subjects, $item->subject);
                    }
                    //      Exham
                    if ($item->control[$semester - 1][1] == true) {
                        array_push($exhamSubjects, $item->subject);
                        array_push($subjects, $item->subject);
                    }
                    //      DPA
                    if ($item->control[$semester - 1][2] == true) {
                        array_push($dpaSubjects, $item->subject);
                        array_push($subjects, $item->subject);

                    }
                    //     Course
                    if ($item->control[$semester - 1][4] == true || $item->control[$semester - 1][5] == true) {
                        array_push($courseSubject, $item->subject);
                        array_push($subjects, $item->subject);

                    }
                }
            }
//            var_dump(count($subjects));die;

            $student_mark = ExportHelpers::getMarks($subjects, $students);

            $curCol = "D";
            if (ExportHelpers::isArrayAndIsEmpty($zalikSubjects)) {
                $start = $curCol;
                foreach ($zalikSubjects as $subject) {
                    $cursor->insertNewColumnBefore($start);
                    $cursor->getColumnDimension($start)->setWidth(3);
                    $cursor->setCellValue("${start}7", $subject->title);
                    $curCol++;
                }
                $end = ExportHelpers::decrementLetter($curCol);
                $cursor->mergeCells("${start}6:${end}6");
                $cursor->setCellValue("${start}6", Yii::t('app', 'Credit'));
            }

            if (ExportHelpers::isArrayAndIsEmpty($courseSubject)) {
                $start = $curCol;
                foreach ($courseSubject as $subject) {
                    $cursor->insertNewColumnBefore($start);
                    $cursor->getColumnDimension($start)->setWidth(3);
                    $cursor->setCellValue("${start}7", $subject->title);
                    $curCol++;
                }
                $end = ExportHelpers::decrementLetter($curCol);
                $cursor->mergeCells("${start}6:${end}6");
                $cursor->setCellValue("${start}6", Yii::t('app', 'Course projects'));
            }

            if (ExportHelpers::isArrayAndIsEmpty($exhamSubjects)) {
                $start = $curCol;
                foreach ($exhamSubjects as $subject) {
                    $cursor->insertNewColumnBefore($start);
                    $cursor->getColumnDimension($start)->setWidth(3);
                    $cursor->setCellValue("${start}7", $subject->title);
                    $curCol++;
                }
                $end = ExportHelpers::decrementLetter($curCol);
                $cursor->mergeCells("${start}6:${end}6");
                $cursor->setCellValue("${start}6", Yii::t('app', 'Exam'));
            }
//            var_dump($dpaSubjects);die;
            if (ExportHelpers::isArrayAndIsEmpty($dpaSubjects)) {
                $start = $curCol;
                foreach ($dpaSubjects as $subject) {
                    $cursor->insertNewColumnBefore($start);
                    $cursor->getColumnDimension($start)->setWidth(3);
                    $cursor->setCellValue("${start}7", $subject->title);
                    $curCol++;
                }
                $end = ExportHelpers::decrementLetter($curCol);
                $cursor->mergeCells("${start}6:${end}6");
                $cursor->setCellValue("${start}6", Yii::t('app', 'DPA'));
            }

            $end = ExportHelpers::decrementLetter($curCol);
            $cursor->removeColumn($curCol);
            $cursor->unmergeCells("C5:${curCol}5");
            $cursor->mergeCells("C5:${end}5");
//        Some new subject put here
//        Use the code written above
            $letter = $marks_column_begin;
            $current = 9;
            foreach ($students as $student) {
                $avg = 0;
                $letter = $marks_column_begin;
                $cursor->insertNewRowBefore($current + 1);
//                $current;
                $cursor->setCellValue("A${current}", $i);
                $i++;

                foreach ($subjects as $subject) {
                    foreach ($student_mark as $mark) {
                        if ($mark["student_id"] == $student->id && $mark["subject_id"] == $subject->id) {
                            $cords = "${letter}${current}";
                            $cursor->setCellValue($cords, $mark["value"]);
                            ExportHelpers::MarkColorized($spreadsheet, $mark["value"], $cords);
                            $avg += $mark["value"];
                        }
                    }
                    $letter++;
                }

//              Name
                $cursor->setCellValue('B' . $current, $student->getFullName());

//              Average mark
                $avg = $avg / count($subjects);
                $avg_avg += $avg;
                array_push($avg_marks, $avg);
                $cursor->setCellValue("${letter}${current}", $avg);

//              Passes
                $current_pass = $pass[array_search($student->id, array_column($pass, "student_id"))];
                $hours_sum[0] += $current_pass["hours"];
                $hours_sum[1] += $current_pass["with_reason"];
                $letter++;
                $pass_row_start_letter = $letter;
                $cursor->setCellValue("${letter}${current}", $current_pass["hours"]);
                $letter++;
                $cursor->setCellValue("${letter}${current}", $current_pass["with_reason"]);
                $letter++;

//              Behaviour
                $letter++;

//              Payment
                if (strcmp($student->getPaymentTypeLabel(), "К") == 0) {
                    $spreadsheet->getActiveSheet()->setCellValue("${letter}${current}", $student->getPaymentTypeLabel());
                }

                $current++;
            }

//          Delete excessive rows
            $cursor->removeRow(8);
            $cursor->removeRow($current--)->removeRow($current);

//          Average marks in column ↓
            $letter = $marks_column_begin;
            $avg_columns = [];
            array_walk_recursive($subjects, function ($subject) use ($student_mark, $students, &$avg_columns) {
                $avg = array_reduce($student_mark, function ($avg, $mark) use ($subject) {
                    if ($subject->id == $mark["subject_id"]) {
                        $avg += $mark["value"];
                    }
                    return $avg;
                });
                $avg = $avg / count($students);
                array_push($avg_columns, $avg);
            });
            $result = [];
            array_walk_recursive($avg_columns, function (&$item) use (&$result) {
                array_push($result, $item);
            });
            foreach ($result as $avg_mark_column) {
                $cursor->setCellValue("${letter}${current}", $avg_mark_column);
                $letter++;
            }
            $cursor->setCellValue("${letter}${current}", $avg_avg / count($students));
            $cursor->getStyle("${letter}${current}")->getNumberFormat()->setFormatCode('0.0');

//          Table footer
            $letter = $pass_row_start_letter;
            $cursor->setCellValue("${letter}${current}", $hours_sum[0]);
            $letter++;
            $cursor->setCellValue("${letter}${current}", $hours_sum[1]);
            $letter = $pass_row_start_letter;
            $current++;
            $cursor->setCellValue("${letter}${current}", $hours_sum[0] / count($pass));
            $letter++;
            $cursor->setCellValue("${letter}${current}", $hours_sum[1] / count($pass));
            $current += 2;
            $footer_current = $current;

//          Counting marks count([5,4,3,2])
            $marks_sum = [0, 0, 0, 0];
            foreach ($avg_marks as $mark) {
                $marks_sum[0] += ($mark >= 4.5) ? 1 : 0;
                $marks_sum[1] += ($mark >= 3.5 && $mark < 4.5) ? 1 : 0;
                $marks_sum[2] += ($mark >= 2.5 && $mark < 3.5) ? 1 : 0;
                $marks_sum[3] += ($mark < 2.5 && $mark < 3.5) ? 1 : 0;
            }
            $current = $footer_current;
            foreach ($marks_sum as $index => $sum) {
                $cursor->setCellValue("B${current}", ExportHelpers::textBetween([ExportHelpers::getMarkLabels()[$index], $sum, "студ."], [45, 5]));
                $cursor->getStyle("B${current}")->getAlignment()->setHorizontal('left');
                $current++;
            }

//          Set date
            $cursor->setCellValue('B' . ($current + 3), Yii::t('app', 'Date') . ": " . date('d.m.Y') . "  " . Yii::t('app', 'Time') . ": " . date('H:i:s'));

//            $cursor->setCellValue('C6', 'Підсумкові');

            $cursor->setCellValue("J301", $year);
            $cursor->setCellValue("J302", $group->title);
            $cursor->setCellValue("J303", $romanSemester);
        }
        return $spreadsheet;
    }


}