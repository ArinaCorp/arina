<?php

namespace app\components\exporters;

use app\components\ExportToExcel;
use app\helpers\GlobalHelper;
use app\modules\accounting\models\YearlyHourAccounting;
use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExportYearlyHourAccounting
{
    /**
     * @param $spreadsheet PhpSpreadsheet\Spreadsheet
     * @param YearlyHourAccounting $yearlyHourAccounting
     * @return PhpSpreadsheet\Spreadsheet
     * @throws PhpSpreadsheet\Exception
     */
    public static function getSpreadsheet($spreadsheet, $yearlyHourAccounting)
    {
        $activeSheet = $spreadsheet->setActiveSheetIndex(0);

        $studyYear = $yearlyHourAccounting->studyYear;
        $teacher = $yearlyHourAccounting->teacher;

        //set year, teacher
        $activeSheet->setCellValue('B3', $studyYear->getTitle());
        $activeSheet->setCellValue('B4', $teacher->getShortName());

        //insert new columns
        $records = $yearlyHourAccounting->hourAccountingRecords;
        $activeSheet->insertNewColumnBefore('B', count($records));
        $columnIndex = Coordinate::columnIndexFromString('B');

        $sumYearTotals = 0;
        $sumPlanTotals = 0;
        $sumIncompleteHours = 0;
        $sumExcessiveHours = 0;
        $sumControlHours = 0;
        $sumGrandYearTotals = 0;

        foreach ($records as $record) {
            $row = 6;
            $column = Coordinate::stringFromColumnIndex($columnIndex);

            $load = $record->load;
            $group = $load->group;
            $subject = $load->workSubject;

            //set course, group name, subject
            $activeSheet->setCellValue($column . $row++, $group->getCourse($studyYear->id));
            $activeSheet->setCellValue($column . $row++, $group->getSystemTitle());
            $activeSheet->setCellValue($column . $row++, $subject->getTitle());

            //set hour per month
            $perYearTotal = 0;
            foreach ($record->hours_per_month as $hour) {
                $perYearTotal += $hour;
                $activeSheet->setCellValue($column . $row++, $hour);
            }

            //set totals
            $activeSheet->setCellValue($column . $row++, $perYearTotal);
            $activeSheet->setCellValue($column . $row++, $perPlanTotal = $load->getPlanTotal());
            $activeSheet->setCellValue($column . $row++, $incompleteHours = $perPlanTotal - $perYearTotal);
            $activeSheet->setCellValue($column . $row++, $excessiveHours = $perYearTotal - $perPlanTotal);
            $activeSheet->setCellValue($column . $row++, $controlHours = 0);
            $activeSheet->setCellValue($column . $row, $grandYearTotal = $perYearTotal + $controlHours);

            $sumYearTotals += $perYearTotal;
            $sumPlanTotals += $perPlanTotal;
            $sumIncompleteHours += $incompleteHours;
            $sumExcessiveHours += $excessiveHours;
            $sumControlHours += $controlHours;
            $sumGrandYearTotals += $grandYearTotal;

            //
            $activeSheet->getColumnDimension($column)->setAutoSize(true);

            $columnIndex++;
        }

        //set per month total
        $row = 9;
        $column = Coordinate::stringFromColumnIndex($columnIndex);

        $monthIndex = 0;
        foreach (GlobalHelper::getWeeksByMonths() as $month => $_) {
            $perMonthTotal = 0;
            foreach ($records as $record) {
                $perMonthTotal += $record->hours_per_month[$monthIndex];
            }
            $activeSheet->setCellValue($column . $row++, $perMonthTotal);
            $monthIndex++;
        }

        //set total cells
        $activeSheet->setCellValue($column . $row++, $sumYearTotals);
        $activeSheet->setCellValue($column . $row++, $sumPlanTotals);
        $activeSheet->setCellValue($column . $row++, $sumIncompleteHours);
        $activeSheet->setCellValue($column . $row++, $sumExcessiveHours);
        $activeSheet->setCellValue($column . $row++, $sumControlHours);
        $activeSheet->setCellValue($column . $row, $sumGrandYearTotals);

        //set styles for added columns
        $styles = array_merge(ExportToExcel::getBorderStyle(), [
                'font' => [
                    'name' => 'Times New Roman',
                    'size' => 16,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            ]
        );

        //merge header cells
        $activeSheet->mergeCells("A1:$column" . "1");
//        $activeSheet->mergeCells("A2:$column" . "2");
//        $activeSheet->mergeCells("A3:$column" . "3");
//        $activeSheet->mergeCells("A6:$column" . "6");

        $activeSheet->getStyle("B6:$column$row")->applyFromArray($styles);
        return $spreadsheet;
    }
}