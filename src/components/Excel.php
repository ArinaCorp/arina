<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\db\Exception;
use PHPExcel;
use PHPExcel_Writer_Excel5;
use PHPExcel_IOFactory;
use PHPExcel_Worksheet;
use PHPExcel_Style_Border;
use PHPExcel_Cell;

use app\modules\plans\models\StudyPlan;
use app\modules\plans\models\StudySubject;
use app\modules\plans\models\WorkPlan;
use app\modules\plans\models\WorkSubject;

class Excel extends Component
{
    public function rome($num)
    {
        $n = intval($num);
        $res = '';

        //array of roman numbers
        $romanNumber_Array = [
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        ];

        foreach ($romanNumber_Array as $roman => $number) {
            $matches = intval($n / $number);
            $res .= str_repeat($roman, $matches);
            $n = $n % $number;
        }

        return $res;
    }

    /**
     * Call method for generation current document
     * @param mixed $data source for document
     * @param $name
     * @throws Exception
     */
    public function getDocument($data, $name)
    {
        $methodName = 'make' . ucfirst($name);
        if (method_exists($this, $methodName)) {
            $objPHPExcel = $this->$methodName($data);
            $docName = "$name " . date("d.m.Y G-i", time());
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $docName . '.xls"');
            header('Cache-Control: max-age=0');
            $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
            $objWriter->save('php://output');
        } else {
            throw new Exception(Yii::t('error', 'Method "{method}" not found', array('{method}' => $methodName)));
        }
    }

    /**
     * Load template document
     * @param $alias
     * @param string $fileType version of template
     * @return PHPExcel
     * @throws Exception
     */
    protected function loadTemplate($alias, $fileType = 'Excel5')
    {
        $fileName = Yii::getAlias($this->templatesPath) . DIRECTORY_SEPARATOR . $alias;
        if (file_exists($fileName)) {
            $objReader = PHPExcel_IOFactory::createReader($fileType);
            $objPHPExcel = $objReader->load($fileName);
            return $objPHPExcel;
        } else {
            throw new Exception(Yii::t('error', 'Template "{name}" not found', array('{name}' => $alias)));
        }
    }

    /**
     * Find alias in cell and replace it into current value
     * @param PHPExcel_Worksheet $sheet
     * @param $cell
     * @param $value
     * @param string $alias
     */
    public function setValue($sheet, $cell, $value, $alias = '@value')
    {
        $sheet->setCellValue($cell, str_replace($alias, $value, $sheet->getCell($cell)->getCalculatedValue()));
    }

    public static function getBorderStyle()
    {
        return [
            'borders' => [
                'allborders' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
    }

    /**
     * Generate study plan document
     * @param $plan StudyPlan
     * @return PHPExcel
     */
    public function makeStudyPlan($plan)
    {
        $tmpfname = Yii::getAlias('@webroot') . "/templates/study-plan.xls";
        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);;
        $objPHPExcel = $excelReader->load($tmpfname);

        //SHEET #1
        $sheet = $sheet = $objPHPExcel->setActiveSheetIndex(0);
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
            $sheet->getStyle("A$i:R$i")->applyFromArray(self::getBorderStyle());
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
        $sheet->getStyle("A$i:R$i")->applyFromArray(self::getBorderStyle());

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
                $sheet->getStyle("T$i:AH$i")->applyFromArray(self::getBorderStyle());
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
                        $sheet->getStyle("AJ$z:BC$z")->applyFromArray(self::getBorderStyle());
                        $z++;
                    }
                }
            }

        }

        //SHEET #2
        $sheet = $sheet = $objPHPExcel->setActiveSheetIndex(2);

        $j = 'N';
        $i = 8;
        foreach ($plan->semesters as $item) {
            $sheet->setCellValue($j . $i, $item);
            $j++;
        }
        $i++;
        $j = 1;
        $totals = array();
        foreach ($plan->getSubjectsByCycles() as $name => $group) {
            $sheet->setCellValue("B$i", $name);
            $sheet->insertNewRowBefore($i + 1, 1);
            $i++;
            $begin = $i;
            $jj = 1;
            foreach ($group as $item) {
                /**@var $item StudySubject */
                $sheet->setCellValue("A$i", $item->subject->code);
                $sheet->setCellValue("B$i", $item->subject->getCycle($plan->speciality_qualification_id)->id . '.' . $jj . $item->getTitle());
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
                $i++;
                $jj++;
            }
            $end = $i - 1;
            $sheet->setCellValue("B$i", Yii::t('base', 'Total'));
            $totals[] = $i;
            for ($c = 'G'; $c < 'V'; $c++) {
                $sheet->setCellValue("$c$i", "=SUM($c$begin:$c$end)");
            }
            $sheet->insertNewRowBefore($i + 1, 1);
            $i++;
            $j++;
        }
        $sheet->setCellValue("B$i", Yii::t('base', 'Total amount'));
        for ($c = 'G'; $c < 'V'; $c++) {
            $sheet->setCellValue("$c$i", "=SUM($c" . implode("+$c", $totals) . ')');
        }
        header('Content-Type: application/vnd.ms-excel');
        $filename = "Study_plan_" . "_" . date("d-m-Y-His") . ".xls";
        header('Content-Disposition: attachment;filename=' . $filename . ' ');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        return $objWriter->save('php://output');
    }

    /**
     * @param $plan WorkPlan
     * @return PHPExcel
     */
    protected function makeWorkPlan($plan)
    {
        $tmpfname = Yii::getAlias('@webroot') . "/templates/work-plan.xls";
        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);;
        $objPHPExcel = $excelReader->load($tmpfname);

        $coursesAmount = $plan->getCourseAmount();
        $groupsByCourse = $plan->specialityQualification->getGroupsByStudyYear($plan->study_year_id);
        $graphOffset = 0;
        for ($i = 0; $i < $coursesAmount; $i++) {
            $groups = [];
            foreach ($groupsByCourse as $group => $course) {
                if ($course == $i + 1) {
                    $groups[] = $group;
                }
            }
            $sheet = $sheet = $objPHPExcel->setActiveSheetIndex($i);
            $this->makeWorkPlanPage($plan, $i + 1, $sheet, $groups, $graphOffset);
            $graphOffset += count($groups);
        }
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        $filename = "Study_plan_" . "_" . date("d-m-Y-His") . ".xls";
        header('Content-Disposition: attachment;filename=' . $filename . ' ');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        return $objWriter->save('php://output');
    }

    /**
     * @param $plan WorkPlan
     * @param $course
     * @param $sheet PHPExcel_Worksheet
     * @param $groups
     * @param $graphOffset
     */
    protected function makeWorkPlanPage($plan, $course, $sheet, $groups, $graphOffset)
    {
        $this->setValue($sheet, 'R8', $course);

        $beginYear = $plan->studyYear->year_start;
        $endYear = $plan->studyYear->getYearEnd();
        $this->setValue($sheet, 'R5', $beginYear, '@begin');
        $this->setValue($sheet, 'R5', $endYear, '@end');
        $this->setValue($sheet, 'Y17', $course);
        $this->setValue($sheet, 'AS17', $course + 1);
        $sheet->setCellValue('AP17', $plan->semesters[$course - 1]);
        $sheet->setCellValue('BJ17', $plan->semesters[$course]);
        $specialityFullName = $plan->specialityQualification->speciality->number . ' "' . $plan->specialityQualification->title . '"';
        $this->setValue($sheet, 'R6', $specialityFullName);
        //groups graph;
        $colNumber = PHPExcel_Cell::columnIndexFromString('G');
        for ($i = 0; $i < count($groups); $i++) {
            $rowIndex = $i + 11;
            $sheet->setCellValue("G$rowIndex", $groups[$i]);
            for ($j = 0; $j < 52; $j++) {
                $colString = PHPExcel_Cell::stringFromColumnIndex($colNumber + $j);
                $k = $i + $graphOffset;
                if (isset($plan->graph[$k][$j])) {
                    $sheet->setCellValue($colString . $rowIndex, Yii::t('plan', $plan->graph[$k][$j]));
                }
            }
            $sheet->getStyle("G$rowIndex:BG$rowIndex")->applyFromArray(self::getBorderStyle());
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
            case 3:
                $fall = 4;
                $spring = 5;
                break;
            case 4:
                $fall = 6;
                $spring = 7;
                break;
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

            $this->workPlanInsertNewLine($sheet, $row);


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

                $sheet->setCellValue("BM$row", $item->cyclicCommission->title);

                $j++;
                $row++;

                $this->workPlanInsertNewLine($sheet, $row);

            }

            $end = $row - 1;

            $sheet->setCellValue("C$row", Yii::t('base', 'Total'));
            $totals[] = $row;
            for ($c = 14; $c < 45; $c++) {
                $index = PHPExcel_Cell::stringFromColumnIndex($c);
                $sheet->setCellValue("$index$row", "=SUM($index$begin:$index$end)");
            }

            $row++;

            $this->workPlanInsertNewLine($sheet, $row);
        }
        $sheet->removeRow($row);
        $sheet->setCellValue("C$row", 'Разом');

        for ($c = 14; $c < 45; $c++) {
            $index = PHPExcel_Cell::stringFromColumnIndex($c);
            $sheet->setCellValue("$index$row", "=SUM($index" . implode("+$index", $totals) . ')');
        }
        $row += 6;
        $this->setValue($sheet, "AD$row", $plan->specialityQualification->speciality->department->head->getFullName());
    }

    /**
     * @param $sheet PHPExcel_Worksheet
     * @param $row
     */
    public function workPlanInsertNewLine($sheet, $row)
    {
        $sheet->insertNewRowBefore($row, 1);
        $sheet->mergeCells("C$row:N$row");
        $exclude = array(32, 38, 52, 58);
        for ($i = 14; $i < 66; $i += 2) {
            if (in_array($i, $exclude)) continue;
            $index1 = PHPExcel_Cell::stringFromColumnIndex($i);
            $index2 = PHPExcel_Cell::stringFromColumnIndex($i + 1);
            $sheet->mergeCells("$index1$row:$index2$row");
        }
    }
}