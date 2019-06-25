<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2019 NRE
 */


namespace app\components\exporters\marks;


use Yii;

class ExportExam extends BaseMarkExporter
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
        $originalMarks = [];
        if ($record->retakeFor) {
            $originalMarks = self::getMarks($record->retakeFor);
        }

        $activeSheet->SetCellValue('A11', $subjectTitle);
        $activeSheet->SetCellValue('D13', $specialityTitle);
        $activeSheet->SetCellValue('A15', $teacherFullName);

        $activeSheet->SetCellValue('C14', $semester);
        $activeSheet->SetCellValue('F14', $course);
        $activeSheet->SetCellValue('I14', $groupTitle);

        if (!is_null($students)) {
            $startRow = 19;
            $current = $startRow;
            $i = 1;
            foreach ($students as $student) {
                $mark = null;
                $activeSheet->insertNewRowBefore($current + 1);
                $activeSheet->mergeCells('B' . $current . ':E' . $current);
                $activeSheet->mergeCells('G' . $current . ':H' . $current);
                $activeSheet->setCellValue('A' . $current, $i);
                $activeSheet->setCellValue('B' . $current, $student->getFullName());
                if (isset($marks[$student->id])) {
                    $mark = $marks[$student->id];
                } elseif (isset($originalMarks[$student->id])) {
                    $mark = $originalMarks[$student->id];
                }
                if ($mark != null) {
                    $activeSheet->setCellValue('F' . $current, $mark->ticket);
                    $activeSheet->setCellValue('G' . $current, $mark->value);
                }
                $activeSheet->setCellValue('I' . $current, $student->getPaymentTypeLabel());
                $i++;
                $current++;
            }
            $activeSheet->removeRow($current);
            $activeSheet->removeRow($current);

            $activeSheet->setCellValue('C' . ($current + 8), Yii::t('app', 'Date') . ": " . date('d.m.Y') . "  " . Yii::t('app', 'Time') . ": " . date('H:i:s'));
        }
        return $spreadsheet;
    }
}