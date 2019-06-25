<?php

namespace app\components\exporters;

use app\components\ExportToExcel;
use app\helpers\GlobalHelper;
use app\modules\accounting\models\YearlyHourAccounting;
use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExportYearlyhouraccounting
{
    /**
     * @param $spreadsheet PhpSpreadsheet\Spreadsheet
     * @param YearlyHourAccounting $yearlyHourAccounting
     * @return PhpSpreadsheet\Spreadsheet
     * @throws PhpSpreadsheet\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public static function getSpreadsheet($spreadsheet, $yearlyHourAccounting)
    {
        $activeSheet = $spreadsheet->setActiveSheetIndex(0);

        $studyYear = $yearlyHourAccounting->studyYear;
        $teacher = $yearlyHourAccounting->teacher;


        //insert new columns
        $records = $yearlyHourAccounting->hourAccountingRecords;
        $activeSheet->insertNewColumnBefore('B', count($records));
        $columnIndex = Coordinate::columnIndexFromString('B');
        $rightBorderIndex = Coordinate::columnIndexFromString('K');

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
            $activeSheet->getColumnDimension($column)->setWidth(6);

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


        //merge header cells
        $rightBorderColumn = Coordinate::stringFromColumnIndex($rightBorderIndex);

        $activeSheet->mergeCells("A1:$rightBorderColumn" . "1");
        $activeSheet->mergeCells("A3:$rightBorderColumn" . "3");
        $activeSheet->mergeCells("A4:$rightBorderColumn" . "4");
        $activeSheet->mergeCells("A28:$rightBorderColumn" . "28");

        //set year, teacher
        $studyYearTitle = $studyYear->getTitle();
        $teacherShortName = $teacher->getShortName();

        $activeSheet->setCellValue('A3', "Навчальний рік - $studyYearTitle");
        $activeSheet->setCellValue('A4', "Викладач - $teacherShortName");
        $activeSheet->setCellValue('A28', "Заступник директора по навчальній роботі ______________________________________");

        //set styles for added columns
        $textStyles = [
            'font' => [
                'name' => 'Times New Roman',
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ]
        ];
        $columnStyles = array_merge(ExportToExcel::getBorderStyle(), $textStyles);

        $activeSheet->getStyle("B6:$column$row")->applyFromArray($columnStyles);

        $activeSheet->getStyle("B8:$column" . "8")->getAlignment()->setTextRotation(90);

        return $spreadsheet;
    }
}