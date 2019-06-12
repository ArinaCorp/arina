<?php


namespace app\components\exporters;

use app\components\ExportHelpers;
use app\modules\plans\models\StudyPlan;
use app\modules\students\models\Group;

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
//        Marks doing over here

//        Marks leave chat


        $id = $data["data"]["group_id"];

        if (!is_null($id)) {
            $group = Group::findOne($id);
            $students = $group->getStudentsArray();
            $studyPlan_id = $data["data"]["plan_id"];
            $studyPlan = StudyPlan::findOne(['id' => $studyPlan_id]);
            $semester = $data["data"]["semester"];
            $romanSemester = ExportHelpers::ConvertToRoman($data["data"]["semester"]);
            $period = 1;
            $subject_titles = [];
            $subjects = [];
            $excel = $spreadsheet->getActiveSheet();
            $failed_students = [];
            $pass = ExportHelpers::getPropusk($students);
            $hours_sum = [0, 0];
            $pass_row_start_letter = "";
            $avg_marks = [];
            $footer_current = 0;
            foreach ($studyPlan->studySubjects as $item) {
                if ($item->weeks[$semester - 1] != 0) {
                    array_push($subject_titles, $item->subject->title);
                    array_push($subjects, ['subject'=>$item->subject]);
                }
            }
            if (count($subject_titles) != 0) {
                $excel->setCellValue('A300', $romanSemester);
                $excel->setCellValue('A301', Date('d.m', strtotime($data['data']['dateFrom'])));
                $excel->setCellValue('B301', Date('d.m', strtotime($data['data']['dateTo'])));
                $excel->setCellValue('A302', Group::findOne($id)->title);
                $excel->setCellValue('A303', Date('Y', strtotime($data['data']['dateFrom'])));
                $excel->setCellValue('B303', Date('Y', strtotime($data['data']['dateTo'])));
                if (!is_null($students)) {
                    $startRow = 8;
                    $current = $startRow;
                    $i = 1;
                    foreach ($students as $student) {
                        $excel->insertNewRowBefore($current + 2);
                        $excel->setCellValue('A' . $current, $i);
                        $excel->setCellValue('B' . $current, $student->getFullName());
                        if (strcmp($student->getPaymentTypeLabel(), "К") == 0)
                            $excel->setCellValue('I' . $current, $student->getPaymentTypeLabel());
                        $i++;
                        $current++;
                    }
                    $excel->removeRow($current + 1);
                    $excel->removeRow($current);
                    $excel->removeRow($current);
                    if (!is_null($subject_titles)) {
                        foreach ($subject_titles as $subject_title) {
                            $excel->setCellValue("D7", $subject_title);
                            $excel->getColumnDimension('D')->setWidth(4);
                            $excel->insertNewColumnBefore("D", 1);
                        }
                        $excel->removeColumn("C");
                        $excel->removeColumn("C");
                        $excel->setCellValue("C5", Yii::t("app", "Subject title"));
                    }

                    $excel->setCellValue('G' . ($current + 7), Yii::t('app', 'Curator') . "________/" . $group->getCuratorShortNameInitialFirst() . "/");
                    $excel->getStyle('G' . ($current + 7))->getFont()->setBold(0)->setSize(12);
                    $excel->setCellValue('G' . ($current + 8), Yii::t('app', 'Student') . "________/" . $group->getGroupLeaderShortNameInitialFirst() . "/");
                    $excel->getStyle('G' . ($current + 8))->getFont()->setBold(0)->setSize(12);
                    $excel->setCellValue('B' . ($current + 8), Yii::t('app', 'Date') . ": " . date('d.m.Y') . "  " . Yii::t('app', 'Time') . ": " . date('H:i:s'));
//                      var $student_marks_two_three to accumulate marks and student (student,2,3)
                    $student_marks_two_three = [];
                    $count = [0, 0, 0];

                    if ($data["data"]['marks_checker']) {
                        $student_mark = ExportHelpers::getMarks($subjects, $students);
                        $current = $startRow;
                        foreach ($students as $student) {
                            $letter = "C";
                            $avg = 0;
                            foreach ($subjects as $subject) {
                                foreach ($student_mark as $mark) {
                                    if ($mark["student_id"] == $student->id && $mark["subject_id"] == $subject['subject']->id) {
                                        $cords = "${letter}${current}";
                                        $excel->setCellValue($cords, $mark["value"]);
                                        $avg += $mark["value"];
                                        ExportHelpers::MarkColorized($spreadsheet, $mark["value"], $cords);
                                        array_push($student_marks_two_three, $mark["value"]);
                                    }
                                }
                                $letter++;
                            }
                            $count[0] += array_filter($student_marks_two_three,function($num){return (int)$num < 2.5;}) ? 1:0;
                            $count[1] += array_filter($student_marks_two_three,function($num){return (int)$num >=2.5 && $num <3.5;}) ? 1:0;
                            $count[2] += array_filter($student_marks_two_three,function($num){return  (int)$num <3.5;}) ? 1:0;

                            $student_marks_two_three = [];
                            $avg = $avg / count($subjects);
                            array_push($avg_marks, $avg);
                            if ($avg < 3.5) {
                                array_push($failed_students, $student);
                            }
                            $excel->setCellValue("${letter}${current}", $avg);
                            $current_pass = $pass[array_search($student->id, array_column($pass, "student_id"))];
                            $hours_sum[0] += $current_pass["hours"];
                            $hours_sum[1] += $current_pass["with_reason"];
                            $letter++;
                            $pass_row_start_letter = $letter;
                            $excel->setCellValue("${letter}${current}", $current_pass["hours"]);
                            $letter++;
                            $excel->setCellValue("${letter}${current}", $current_pass["with_reason"]);
                            $current++;
                        }

                        $letter = $pass_row_start_letter;
                        $excel->setCellValue("${letter}${current}", $hours_sum[0]);
                        $letter++;
                        $excel->setCellValue("${letter}${current}", $hours_sum[1]);
                        $letter = $pass_row_start_letter;
                        $current++;
                        $excel->setCellValue("${letter}${current}", $hours_sum[0] / count($pass));
                        $letter++;
                        $excel->setCellValue("${letter}${current}", $hours_sum[1] / count($pass));
                        $quality = round((count($students) - $count[2]) / count($students) * 100, 2);
                        $success_rate = round((count($students)- $count[0]) / count($students) * 100, 2);
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
                }
            }
        }
        return $spreadsheet;
    }
//    private static function calculateDate($studyPlan, $semester, $period, $date)
//    {
//        $daysFrom = 0;
//        $daysTo = 0;
//        $i = 1;
//        foreach ($studyPlan->semesters as $week) {
//
//            if ($i < $semester) {
//                $daysFrom += $week * 7;
//            }
//            if ($i < $semester + $period) {
//                $daysTo += $week * 7;
//            }
//            $i++;
//        }
//        if ($semester == 1) {
//            $daysFrom = 0;
//        }
//        if ($semester == 8) {
//            $daysTo = 0;
//        }
//        $beginDate = Date("d.m", strtotime($date . "+" . $daysFrom . " days"));
//        $endDate = Date("d.m", strtotime($date . "+" . $daysTo . " days"));
//        return [$beginDate, $endDate];
//    }
}