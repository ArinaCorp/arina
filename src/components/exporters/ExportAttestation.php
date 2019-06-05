<?php


namespace app\components\exporters;

use app\components\ExportHelpers;
use app\modules\plans\models\StudyPlan;
use app\modules\students\models\Group;

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
            foreach ($studyPlan->studySubjects as $item) {
                if ($item->weeks[$semester - 1] != 0) {
                    array_push($subject_titles, $item->subject->title);
                    array_push($subjects, $item->subject);
                }
            }
            $student_mark = ExportHelpers::getMarks($subjects, $students);
//            var_dump($student_mark);die;
            if (count($subject_titles) != 0) {
                $date = self::calculateDate($studyPlan, $semester, $period, $data["data"]["date"]);
                $firstYear = Date('Y', strtotime($data["data"]["date"]));
                $year = [$firstYear, $firstYear + 1];

                $excel->setCellValue('A300', $romanSemester);
                $excel->setCellValue('A301', $date[0]);
                $excel->setCellValue('B301', $date[1]);
                $excel->setCellValue('A302', Group::findOne($id)->title);
                $excel->setCellValue('A303', $year[0]);
                $excel->setCellValue('B303', $year[1]);
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
                    $excel->setCellValue('G' . ($current + 8), Yii::t('app', 'Student') . "________/" . $group->getGroupLeaderShortNameInitialFirst() . "/");
                    $excel->setCellValue('B' . ($current + 8), Yii::t('app', 'Date') . ": " . date('d.m.Y') . "  " . Yii::t('app', 'Time') . ": " . date('H:i:s'));
                    $excel->getStyle('G' . ($current + 7))->getFont()->setBold(1000)->setSize(12);
                    $excel->getStyle('G' . ($current + 8))->getFont()->setBold(1000)->setSize(12);
                    $current = $startRow;
                    $letter = 'C';
                    $faild_students = [];
                    $pass = ExportHelpers::getPropusk($students);
                    $hours_sum = [0, 0];
                    $pass_row_start_letter = "";
                    foreach ($students as $student) {
                        $letter = "C";
                        $avg = 0;
                        foreach ($subjects as $subject) {
                            foreach ($student_mark as $mark) {
                                if ($mark["student_id"] == $student->id && $mark["subject_id"] == $subject->id) {
                                    $cords = "${letter}${current}";
                                    $excel->setCellValue($cords, $mark["value"]);
                                    ExportHelpers::MarkColorized($spreadsheet, $mark["value"], $cords);
                                    $avg += $mark["value"];
                                }
                            }
                            $letter++;
                        }
                        $avg = $avg / count($subjects);
                        if ($avg <= 3) {
                            array_push($faild_students, $student);
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
                    $excel->setCellValue("${letter}${current}", $hours_sum[0]/count($pass));
                    $letter++;
                    $excel->setCellValue("${letter}${current}", $hours_sum[1]/count($pass));
                    $quality = (count($students) - count($faild_students)) / count($students) * 100;
                    $current += 2;
                    $excel->setCellValue("I${current}", "Якість       ${quality}%");
                    $current++;
                    $excel->setCellValue("I${current}", "Успішність       ${quality}%");
                }
            }
        }
        return $spreadsheet;
    }

    private static function calculateDate($studyPlan, $semester, $period, $date)
    {
        $daysFrom = 0;
        $daysTo = 0;
        $i = 1;
        foreach ($studyPlan->semesters as $week) {

            if ($i < $semester) {
                $daysFrom += $week * 7;
            }
            if ($i < $semester + $period) {
                $daysTo += $week * 7;
            }
            $i++;
        }
        if ($semester == 1) {
            $daysFrom = 0;
        }
        if ($semester == 8) {
            $daysTo = 0;
        }
        $beginDate = Date("d.m", strtotime($date . "+" . $daysFrom . " days"));
        $endDate = Date("d.m", strtotime($date . "+" . $daysTo . " days"));
        return [$beginDate, $endDate];
    }


}