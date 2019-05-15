<?php


namespace app\components\exporters;

use app\components\ExportHelpers;
use app\modules\directories\models\subject\Subject;
use app\modules\plans\models\StudyPlan;
use app\modules\students\models\Group;
use PhpOffice\PhpSpreadsheet;

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

        $zalikSubjects = [];
        $courseSubject = [];
        $exhamSubjects = [];
        $dpaSubjects = ['D1', "D2"];

        $studyPlan_id = $data["data"]["plan_id"];
        $studyPlan = StudyPlan::findOne(['id' => $studyPlan_id]);

        $romanSemester = ExportHelpers::ConvertToRoman($semester);

        $students = $group->getStudentsArray();
        $current = 9;
        $i = 1;
        $beforeRow = null;
        foreach ($students as $student) {
            $cursor->insertNewRowBefore($current + 1);
            $beforeRow = $current - 1;
            $cursor->setCellValue("A${beforeRow}", $i);
            if ($student->getPaymentTypeLabel() == "K")
                $spreadsheet->getActiveSheet()->setCellValue('I' . $beforeRow, $student->getPaymentTypeLabel());
            $cursor->setCellValue('B' . $beforeRow, $student->getFullName());
            $i++;
            $current++;
        }
        $beforeRow = $current - 1;
        $cursor->removeRow($beforeRow);
        $cursor->removeRow($beforeRow);
        $cursor->removeRow($beforeRow);

        $subjectCounter = ExportHelpers::coundLengthOfMultipleArrays([$zalikSubjects,$courseSubject,$exhamSubjects,$dpaSubjects]);
        if($subjectCounter!=0){
        foreach ($studyPlan->studySubjects as $item) {
            if ($item->weeks[$semester - 1] != 0) {
                //      Zalik
                if ($item->control[$semester - 1][0] == true) {
                    array_push($zalikSubjects, $item->subject->title);
                }
                //      Exham
                if ($item->control[$semester - 1][1] == true) {
                    array_push($exhamSubjects, $item->subject->title);
                }
                //      DPA
                if ($item->control[$semester - 1][2] == true) {
                    array_push($dpaSubjects, $item->subject->title);
                }
                //     Course
                if ($item->control[$semester - 1][4] == true || $item->control[$semester - 1][5] == true) {
                    array_push($courseSubject, $item->subject->title);
                }
            }
        }

        $curCol = "D";
        if (ExportHelpers::isArrayAndIsEmpty($zalikSubjects)) {
            $start = $curCol;
            foreach ($zalikSubjects as $subject) {
                $cursor->insertNewColumnBefore($start);
                $cursor->getColumnDimension($start)->setWidth(3);
                $cursor->setCellValue("${start}7", $subject);
                $curCol++;
            }
            $end = ExportHelpers::decrementLetter($curCol);
            $cursor->mergeCells("${start}6:${end}6");
            $cursor->setCellValue("${start}6", "Залік");
        }

        if (ExportHelpers::isArrayAndIsEmpty($courseSubject)) {
            $start = $curCol;
            foreach ($courseSubject as $subject) {
                $cursor->insertNewColumnBefore($start);
                $cursor->getColumnDimension($start)->setWidth(3);
                $cursor->setCellValue("${start}7", $subject);
                $curCol++;
            }
            $end = ExportHelpers::decrementLetter($curCol);
            $cursor->mergeCells("${start}6:${end}6");
            $cursor->setCellValue("${start}6", "Курсові");
        }

        if (ExportHelpers::isArrayAndIsEmpty($exhamSubjects)) {
            $start = $curCol;
            foreach ($exhamSubjects as $subject) {
                $cursor->insertNewColumnBefore($start);
                $cursor->getColumnDimension($start)->setWidth(3);
                $cursor->setCellValue("${start}7", $subject);
                $curCol++;
            }
            $end = ExportHelpers::decrementLetter($curCol);
            $cursor->mergeCells("${start}6:${end}6");
            $cursor->setCellValue("${start}6", "Екзамен");
        }

        if (ExportHelpers::isArrayAndIsEmpty($dpaSubjects)) {
            $start = $curCol;
            foreach ($dpaSubjects as $subject) {
                $cursor->insertNewColumnBefore($start);
                $cursor->getColumnDimension($start)->setWidth(3);
                $cursor->setCellValue("${start}7", $subject);
                $curCol++;
            }
            $end = ExportHelpers::decrementLetter($curCol);
            $cursor->mergeCells("${start}6:${end}6");
            $cursor->setCellValue("${start}6", "ДПА");
        }

        $end = ExportHelpers::decrementLetter($curCol);
        $cursor->removeColumn($curCol);
        $cursor->unmergeCells("C5:${curCol}5");
        $cursor->mergeCells("C5:${end}5");

//        Some new subject put here
//        Use the code written above

        $cursor->setCellValue('B' . ($current + 9), "Дата: " . date('d.m.Y') . "  Час: " . date('H:i:s'));

        $cursor->setCellValue('C6', 'Підсумкові');

        $cursor->setCellValue("J301", $year);
        $cursor->setCellValue("J302", $group->title);
        $cursor->setCellValue("J303", $romanSemester);
        }
        return $spreadsheet;
    }


}