<?php
/**
 * Created by PhpStorm.
 * User: wenceslaus
 * Date: 5/21/18
 * Time: 6:40 PM
 */

namespace app\components\exporters;


use app\components\ExportToExcel;
use app\modules\plans\models\WorkPlan;
use app\modules\plans\models\WorkSubject;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Yii;

class ExportWorkplan
{
    /**
     * @param $spreadsheet Spreadsheet
     * @param $plan StudentPlan
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @return Spreadsheet
     */
    public static function getSpreadsheet($spreadsheet, $plan)
    {
        $coursesAmount = $plan->getCourseAmount();
        $groupsByCourse = $plan->specialityQualification->getGroupsByStudyYear($plan->study_year_id);
        $graphOffset = 0;
        // TODO: Workplans are not copmlete
        for ($i = 0; $i < 3; $i++) {
//        for ($i = 0; $i < $coursesAmount; $i++) {
            $groups = [];
            foreach ($groupsByCourse as $group => $course) {
                if ($course == $i + 1) {
                    $groups[] = $group;
                }
            }
            $sheet = $spreadsheet->setActiveSheetIndex($i);
            ExportWorkplan::makeWorkPlanPage($plan, $i + 1, $sheet, $groups, $graphOffset);
            $graphOffset += count($groups);
        }
        $spreadsheet->setActiveSheetIndex(0);

        return $spreadsheet;
    }

    /**
     * Find alias in cell and replace it into current value
     * @param Worksheet $sheet
     * @param $cell
     * @param $value
     * @param string $alias
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */

    private static function setValue($sheet, $cell, $value, $alias = '@value')
    {
        $sheet->setCellValue($cell, str_replace($alias, $value, $sheet->getCell($cell)->getCalculatedValue()));
    }


    /**
     * @param $plan WorkPlan
     * @param $course
     * @param $sheet Worksheet
     * @param $groups
     * @param $graphOffset
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */

    protected static function makeWorkPlanPage($plan, $course, $sheet, $groups, $graphOffset)
    {
        ExportWorkplan::setValue($sheet, 'R8', $course);

        $beginYear = $plan->studyYear->year_start;
        $endYear = $plan->studyYear->getYearEnd();
        ExportWorkplan::setValue($sheet, 'R5', $beginYear, '@begin');
        ExportWorkplan::setValue($sheet, 'R5', $endYear, '@end');
        ExportWorkplan::setValue($sheet, 'Y17', $course);
        ExportWorkplan::setValue($sheet, 'AS17', $course + 1);
        $sheet->setCellValue('AP17', $plan->semesters[$course - 1]);
        $sheet->setCellValue('BJ17', $plan->semesters[$course]);
        $specialityFullName = $plan->specialityQualification->speciality->number . ' "' . $plan->specialityQualification->title . '"';
        ExportWorkplan::setValue($sheet, 'R6', $specialityFullName);
        //groups graph;
//        $colNumber = PHPExcel_Cell::columnIndexFromString('G');
//        $colNumber = Coordinate::columnIndexFromString('G');
        $colNumber = Coordinate::columnIndexFromString('H');
        for ($i = 0; $i < count($groups); $i++) {
            $rowIndex = $i + 11;
//            $sheet->setCellValue("G$rowIndex", $groups[$i]);
            $sheet->setCellValue("H$rowIndex", $groups[$i]);
            for ($j = 0; $j < 52; $j++) {
//                $colString = PHPExcel_Cell::stringFromColumnIndex($colNumber + $j);
                $colString = Coordinate::stringFromColumnIndex($colNumber + $j);
                $k = $i + $graphOffset;
                if (isset($plan->graph[$k][$j])) {
                    $sheet->setCellValue($colString . $rowIndex, Yii::t('plans', $plan->graph[$k][$j]));
                }
            }
//            $sheet->getStyle("G$rowIndex:BG$rowIndex")->applyFromArray(self::getBorderStyle());
            $sheet->getStyle("H$rowIndex:BG$rowIndex")->applyFromArray(ExportToExcel::getBorderStyle());
        }

        //hours table
        switch ($course) {
            case 1:
                $fall = 0;
                $spring = 1;
                break;
            case 2:
                $fall = 2;
                $spring = 3;
                break;
                // TODO: Workplans have only 4 semester smh
//            case 3:
//                $fall = 4;
//                $spring = 5;
//                break;
//            case 4:
//                $fall = 6;
//                $spring = 7;
//                break;
            default:
                $fall = 0;
                $spring = 1;
        }

        $row = 23;
        $i = 0;
        $id = 1;
        $totals = [];
        $subjectsGroups = $plan->getSubjectsByCycles($course);
        foreach ($subjectsGroups as $cycle => $subjects) {

            $sheet->setCellValue("C$row", $cycle);
            $sheet->setCellValue("A$row", $id++);


            $i++;
            $row++;

            ExportWorkplan::workPlanInsertNewLine($sheet, $row);


            $j = 0;
            $begin = $row;
            foreach ($subjects as $item) {


                /**@var $item WorkSubject */
                $sheet->setCellValue("B$row", $item->subject->code);
                $sheet->setCellValue("A$row", $id++);
                $sheet->setCellValue("C$row", $item->subject->getCycle($plan->speciality_qualification_id)->id . '.' . ($j + 1) . ' ' . $item->getTitle());
                $sum = array_sum(isset($item->subject) ? $item->total : array());
                $sheet->setCellValue("O$row", $sum / 54);
                $sheet->setCellValue("Q$row", $sum);
                //FALL
                $sheet->setCellValue("Y$row", $item->total[$fall]);
                $sheet->setCellValue("AA$row", $item->getClasses($fall));
                $sheet->setCellValue("AC$row", $item->lectures[$fall]);
                $sheet->setCellValue("AE$row", $item->lab_works[$fall]);
                $sheet->setCellValue("AG$row", $item->practices[$fall]);
                $sheet->setCellValue("AI$row", $item->getSelfwork($fall));
                $sheet->setCellValue("AK$row", ($item->control[$fall][4] || $item->control[$fall][5]) ? $item->project_hours : '');
                $sheet->setCellValue("AN$row", $item->weeks[$fall]);
                $sheet->setCellValue("AO$row", (($item->control[$fall][1]) ? 1 : ''));
                $sheet->setCellValue("AQ$row", (($item->control[$fall][0]) ? 1 : ''));

                //SPRING
                $sheet->setCellValue("AS$row", $item->total[$spring]);
                $sheet->setCellValue("AU$row", $item->getClasses($spring));
                $sheet->setCellValue("AW$row", $item->lectures[$spring]);
                $sheet->setCellValue("AY$row", $item->lab_works[$spring]);
                $sheet->setCellValue("BA$row", $item->practices[$spring]);
                $sheet->setCellValue("BC$row", $item->getSelfwork($spring));
                $sheet->setCellValue("BE$row", ($item->control[$spring][4] || $item->control[$spring][5]) ? $item->project_hours : '');
                $sheet->setCellValue("BH$row", $item->weeks[$spring]);
                $sheet->setCellValue("BI$row", (($item->control[$spring][1]) ? 1 : ''));
                $sheet->setCellValue("BK$row", (($item->control[$spring][0]) ? 1 : ''));

                //CYCLE COMMISSION

//                No object exception - Fix
                $sheet->setCellValue("BM$row", $item->cyclicCommission ? $item->cyclicCommission->short_title : ' ');
//                $sheet->setCellValue("BM$row", "TROUBLEMAKER");

                $j++;
                $row++;

                ExportWorkplan::workPlanInsertNewLine($sheet, $row);

            }

            $end = $row - 1;

            $sheet->setCellValue("C$row", Yii::t('app', 'Total'));
            $totals[] = $row;
//            Changed it because after fixes every cycle begins from 15
//            for ($c = 14; $c < 45; $c++) {
            $exclude = array(33, 39, 53, 59);
            for ($c = 15; $c < 45; $c++) {
//                $index = PHPExcel_Cell::stringFromColumnIndex($c);
                $index = Coordinate::stringFromColumnIndex($c);
                $sheet->setCellValue("$index$row", "=SUM($index$begin:$index$end)");
//                Optional fixes. Better safe than sorry
                if (in_array($c, $exclude)) {
                    $index = Coordinate::stringFromColumnIndex($c + 1);
                    $sheet->setCellValue("$index$row", "=SUM($index$begin:$index$end)");
                }
            }

            $row++;

            ExportWorkplan::workPlanInsertNewLine($sheet, $row);
        }
        $sheet->removeRow($row);
        $sheet->setCellValue("C$row", 'Разом');

//        There was a mistake in cycle values
//        for ($c = 14; $c < 45; $c++) {
        $exclude = array(33, 39, 53, 59);
        for ($c = 15; $c < 45; $c += 2) {
//            $index = PHPExcel_Cell::stringFromColumnIndex($c);
            $index = Coordinate::stringFromColumnIndex($c);

//            Caused File Corruption - Fixed
//            $sheet->setCellValue("$index$row", "=SUM($index" . implode("+$index", $totals) . ')');
            $sheet->setCellValue("$index$row", "=SUM($index" . implode(",$index", $totals) . ")");
            if (in_array($c, $exclude)) {
                $index = Coordinate::stringFromColumnIndex($c + 1);
                $sheet->setCellValue("$index$row", "=SUM($index" . implode(",$index", $totals) . ")");
            }
        }
        $row += 6;
//        Call to a member function getFullName() on null - Fix it
//        ExportWorkplan::setValue($sheet, "AD$row", $plan->specialityQualification->speciality->department->head->getFullName());
        $depHead = $plan->specialityQualification->speciality->department->head;
        ExportWorkplan::setValue($sheet, "AD$row", $depHead ? $plan->specialityQualification->speciality->department->head->getFullName() : ' ');

    }

    /**
     * @param $sheet Worksheet
     * @param $row
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */

    public static function workPlanInsertNewLine($sheet, $row)
    {
        $sheet->insertNewRowBefore($row, 1);
        $sheet->mergeCells("C$row:N$row");
//        $exclude = array(32, 38, 52, 58);
        $exclude = array(33, 39, 53, 59);
//        prev value = 14
        for ($i = 15; $i < 66; $i += 2) {
            if (in_array($i, $exclude)) continue;
//            $index1 = PHPExcel_Cell::stringFromColumnIndex($i);
            $index1 = Coordinate::stringFromColumnIndex($i);
//            $index2 = PHPExcel_Cell::stringFromColumnIndex($i + 1);
            $index2 = Coordinate::stringFromColumnIndex($i + 1);
            $sheet->mergeCells("$index1$row:$index2$row");
        }
    }


}