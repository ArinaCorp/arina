<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2019 NRE
 */


namespace app\components\exporters\marks;


use app\components\ExportHelpers;
use Yii;

class ExportCredit extends BaseMarkExporter
{

    /**
     * @param \PhpOffice\PhpSpreadsheet\Spreadsheet $spreadsheet
     * @param \app\modules\journal\models\record\JournalRecord $record
     * @return mixed|\PhpOffice\PhpSpreadsheet\Spreadsheet
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function getSpreadsheet($spreadsheet, $record)
    {
        $activeSheet = $spreadsheet->setActiveSheetIndex(0);

        $load = $record->load;

        $subjectTitle = $load->workSubject->getTitle();
        $specialityTitle = $load->workSubject->workPlan->specialityQualification->speciality->title;
        $teacherFullName = $load->employee->getFullName();

        $semester = $load->group->getSemester();
        $course = $load->group->getCourse($load->study_year_id);
        $groupTitle = $load->group->getSystemTitle();

        $students = self::getStudents($record);
        $marks = self::getMarks($record);

        $activeSheet->SetCellValue('A11', $subjectTitle);
        $activeSheet->SetCellValue('D13', $specialityTitle);
        $activeSheet->SetCellValue('A15', $teacherFullName);

        $activeSheet->SetCellValue('C14', $semester);
        $activeSheet->SetCellValue('F14', $course);
        $activeSheet->SetCellValue('H14', $groupTitle);

        if (!is_null($students)) {

            $failed_students = 0;
            $avg = 0;
            $student_marks_two_three = [];
            $count = [0, 0, 0];

            $startRow = 19;
            $current = $startRow;
            $i = 1;
            foreach ($students as $student) {
                $activeSheet->insertNewRowBefore($current + 1);
                $activeSheet->mergeCells('B' . $current . ':E' . $current);
                $activeSheet->mergeCells('F' . $current . ':G' . $current);
                $activeSheet->setCellValue('A' . $current, $i);
                $activeSheet->setCellValue('B' . $current, $student->getFullName());
                if (isset($marks[$student->id])) {
                    $mark = $marks[$student->id];
                    $activeSheet->setCellValue('F' . $current, $mark->value);

                    $avg += $mark->value;
                    $failed_students += $mark->value < 3.5 ? 1 : 0;
                    $student_marks_two_three[] = $mark->value;
                }
                $activeSheet->setCellValue('H' . $current, $student->getPaymentTypeLabel());
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
            $activeSheet->removeRow($current);
            $activeSheet->removeRow($current);

//            $activeSheet->setCellValue("F${current}", count($marks) != 0 ? (round($avg / count($marks), 2)) : "");
//            $quality = count($marks) != 0 ? (round((count($students) - $count[2]) / count($marks) * 100, 2)) : "  ";
//            $success_rate = count($marks) != 0 ? (round((count($students) - $count[0]) / count($marks) * 100, 2)) : "  ";;
//            $current += 2;
//            $footer_current = $current;
//            $activeSheet->setCellValue("H${current}", "${success_rate} %");
//            $current++;
//            $activeSheet->setCellValue("H${current}", "${quality} %");
//            $marks_sum = [0, 0, 0, 0];
//            $marks = array_map(function ($item) {
//                return $item["value"];
//            }, $marks);
//            foreach ($marks as $mark) {
//                $marks_sum[0] += ($mark >= 4.5) ? 1 : 0;
//                $marks_sum[1] += ($mark >= 3.5 && $mark < 4.5) ? 1 : 0;
//                $marks_sum[2] += ($mark >= 2.5 && $mark < 3.5) ? 1 : 0;
//                $marks_sum[3] += ($mark < 2.5 && $mark < 3.5) ? 1 : 0;
//            }
//            $current = $footer_current;
//            foreach ($marks_sum as $index => $sum) {
//                $activeSheet->setCellValue("B${current}", ExportHelpers::textBetween([ExportHelpers::getMarkLabels()[$index], $sum, "студ."], [40, 5]));
//                $activeSheet->getStyle("B${current}")->getAlignment()->setHorizontal('left');
//                $current++;
//            }
            $activeSheet->setCellValue('C' . ($current + 8), Yii::t('app', 'Date') . ": " . date('d.m.Y') . "  " . Yii::t('app', 'Time') . ": " . date('H:i:s'));
        }
        return $spreadsheet;
    }
}