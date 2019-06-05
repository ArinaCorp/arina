<?php
/**
 * Created by PhpStorm.
 * User: wenceslaus
 * Date: 5/21/18
 * Time: 7:01 PM
 */

namespace app\components\exporters;


use app\components\ExportToExcel;
use app\modules\plans\models\StudyPlan;
use app\modules\plans\models\StudySubject;
use PhpOffice\PhpSpreadsheet\Calculation\Calculation;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Yii;

class ExportStudyplan
{
    /**
     * @param $spreadsheet Spreadsheet
     * @param $plan StudyPlan
     * @return mixed
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */

    public static function getSpreadsheet($spreadsheet, $plan)
    {
        //SHEET #1
//        $sheet = $sheet = $objPHPExcel->setActiveSheetIndex(0);
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $sheet->setCellValue("F19", $plan->specialityQualification->speciality->number . ' ' . $plan->specialityQualification->speciality->title);

        // table #1
        for ($i = 0; $i < count($plan->graph); $i++) {
            $char = 'B';
            for ($j = 0; $j < count($plan->graph[$i]); $j++) {
                $sheet->setCellValue($char . ($i + 32), Yii::t('plans', $plan->graph[$i][$j]));
                $char++;
            }
        }

        // table #2
        $i = 46;
        $totals = array(
            'T' => 0,
            'P' => 0,
            'DA' => 0,
            'DP' => 0,
            'H' => 0,
            'S' => 0,
            ' ' => 0,
        );
        foreach ($plan->graph as $item) {
            $result = array_count_values($item);
            foreach ($result as $key => $value) {
                $totals[$key] += $value;
            }

            $sheet->setCellValue('A' . $i, $i - 45);
            if (isset($result['S'])) {
                $sheet->setCellValue('E' . $i, $result['S']);
            }
            if (isset($result['P'])) {
                $sheet->setCellValue('G' . $i, $result['P']);
            }
            if (isset($result['DA'])) {
                $sheet->setCellValue('I' . $i, $result['DA']);
            }
            if (isset($result['DP'])) {
                $sheet->setCellValue('K' . $i, $result['DP']);
            }
            if (isset($result['T'])) {
                $sheet->setCellValue('C' . $i, $result['T']);
            }
            if (isset($result['H'])) {
                $sheet->setCellValue('M' . $i, $result['H']);
            }
            if (isset($result[' '])) {
                $sheet->setCellValue('P' . $i, 52 - $result[' ']);
            } else {
                $sheet->setCellValue('P' . $i, 52);
            }
            $sheet->getStyle("A$i:R$i")->applyFromArray(ExportToExcel::getBorderStyle());
            $i++;
        }
        $sheet->setCellValue('A' . $i, 'Разом');
        $sheet->setCellValue('E' . $i, $totals['S']);
        $sheet->setCellValue('G' . $i, $totals['P']);
        $sheet->setCellValue('I' . $i, $totals['DA']);
        $sheet->setCellValue('K' . $i, $totals['DP']);
        $sheet->setCellValue('C' . $i, $totals['T']);
        $sheet->setCellValue('M' . $i, $totals['H']);
        $sheet->setCellValue('P' . $i, 52 * count($plan->graph) - $totals[' ']);
        $sheet->getStyle("A$i:R$i")->applyFromArray(ExportToExcel::getBorderStyle());

        // table #3 / table #4
        $i = 46;
        $z = 46;
        foreach ($plan->studySubjects as $item) {
            if ($item->subject->practice) {
                $sheet->setCellValue('T' . $i, $item->subject->title);
                $sheet->setCellValue('AG' . $i, $item->practice_weeks);
                for ($j = 0; $j < count($item->control); $j++) {
                    if ($item->control[$j][0]) {
                        $sheet->setCellValue("AF$i", $j + 1);
                    }
                }
                $sheet->getStyle("T$i:AH$i")->applyFromArray(ExportToExcel::getBorderStyle());
                $i++;
            }
            for ($k = 0; $k < count($item->control); $k++) {
                $semester = $item->control[$k];
                $list = array(2 => 'ДПА', 3 => 'ДА');
                foreach ($list as $key => $name) {
                    if ($semester[$key]) {
                        $sheet->setCellValue("AJ$z", $item->subject->title);
                        $sheet->setCellValue("AT$z", $name);
                        $sheet->setCellValue("BC$z", $k + 1);
                        $sheet->getStyle("AJ$z:BC$z")->applyFromArray(ExportToExcel::getBorderStyle());
                        $z++;
                    }
                }
            }

        }

        //SHEET #2
//        $sheet = $sheet = $objPHPExcel->setActiveSheetIndex(2);
        /** @var Worksheet $sheet */
        $sheet = $spreadsheet->setActiveSheetIndex(2);

        $j = 'N';
        $i = 8;
        foreach ($plan->semesters as $item) {
            $sheet->setCellValue($j . $i, $item);
            $j++;
        }
        $i++;
        $j = 1;
        $totals = array();

        /**
         * @param Worksheet $sheet
         * @param StudySubject $item
         * @param $i
         */
        function processSubject($sheet, $item, $i)
        {
            $sheet->setCellValue("A$i", $item->subject->code);
            $sheet->setCellValue("B$i", $item->getTitle());
            $sheet->setCellValue("C$i", $item->getExamSemesters());
            $sheet->setCellValue("D$i", $item->getTestSemesters());
            $sheet->setCellValue("E$i", $item->getWorkSemesters());
            $sheet->setCellValue("F$i", $item->getProjectSemesters());
            $sheet->setCellValue("G$i", round($item->total / 54, 2));
            $sheet->setCellValue("H$i", $item->total);
            $sheet->setCellValue("I$i", $item->getClasses());
            $sheet->setCellValue("J$i", $item->lectures);
            $sheet->setCellValue("K$i", $item->lab_works);
            $sheet->setCellValue("L$i", $item->practices);
            $sheet->setCellValue("M$i", $item->getSelfwork());
            $char = 'N';
            foreach ($item->weeks as $key => $week) {
                $sheet->setCellValue($char . $i, $week);
                $char++;
            }
            $sheet->insertNewRowBefore($i + 1, 1);
        }

        foreach ($plan->getCyclesWithSubjects() as $cycle) {
            $sheet->setCellValue("B$i", $j . '. ' . $cycle['title'])
                ->insertNewRowBefore($i + 1, 1);
            $i++;
            $begin = $i;
            $jj = 1;
            if (isset($cycle['subjects'])) {
                foreach ($cycle['subjects'] as $subject) {
                    processSubject($sheet, $subject, $i);
                    $i++;
                }
            }
            if (isset($cycle['children'])) {
                foreach ($cycle['children'] as $subcycle) {
                    $sheet->setCellValue("B$i", $j . '.' . $jj . ' ' . $subcycle['title'])
                        ->insertNewRowBefore($i + 1, 1);
                    $i++;
                    foreach ($subcycle['subjects'] as $subject) {
                        processSubject($sheet, $subject, $i);
                        $i++;
                    }
                    $jj++;
                }
            }
            $end = $i - 1;
            $sheet->setCellValue("B$i", Yii::t('app', 'Total'));
            $totals[] = $i;
            for ($c = 'G'; $c < 'V'; $c++) {
                $sheet->setCellValue("$c$i", "=SUM($c$begin:$c$end)");
            }
            $sheet->insertNewRowBefore($i + 1, 1);
            $i++;
            $j++;
        }

        $sheet->setCellValue("B$i", Yii::t('app', 'Total amount'));
        for ($c = 'G'; $c < 'V'; $c++) {
            $sheet->setCellValue("$c$i", "=SUM($c" . implode("+$c", $totals) . ')');
        }

//        Show first sheet when open.
        $spreadsheet->setActiveSheetIndex(0);

        Calculation::getInstance()->disableCalculationCache();

        return $spreadsheet;
    }
}