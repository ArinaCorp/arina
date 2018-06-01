<?php
/**
 * Created by PhpStorm.
 * User: wenceslaus
 * Date: 5/22/18
 * Time: 1:32 PM
 */

namespace app\components\exporters;


use app\modules\load\models\Load;
use app\modules\students\models\Group;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class LoadExporter extends BaseExporter
{
    /**
     * @param $spreadsheet Spreadsheet
     * @param $data
     * @param $optional null
     * @return Spreadsheet
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public static function getSpreadsheet($spreadsheet, $data, $optional = null)
    {
        $sheet = $spreadsheet->setActiveSheetIndex(0);
        $row = 6;
        $i = 1;
        /**
         * @var $load Load
         */
        foreach ($data as $load) {

            $springSemester = $load->course * 2 - 1;
            $fallSemester = $springSemester - 1;
            $sheet->setCellValue("A$row", $i);
            $subject = $load->planSubject->subject;
            $sheet->setCellValue("B$row", $subject->code);
            $sheet->setCellValue("C$row", $subject->title);
            $sheet->setCellValue("D$row", (isset($load->teacher) ? $load->teacher->getNameWithInitials() : 'непризначено'));

            /**
             * @var $group Group
             */
            $group = $load->group;

            $sheet->setCellValue("E$row", $group->getCourse($load->study_year_id));
            $sheet->setCellValue("F$row", $group->title);
            $sheet->setCellValue("G$row", $load->getStudentsCount());
            $sheet->setCellValue("H$row", $load->getBudgetStudentsCount());
            $sheet->setCellValue("I$row", $load->getContractStudentsCount());
            $sheet->setCellValue("J$row", $load->getPlanCredits());
            $sheet->setCellValue("K$row", $load->getPlanTotal());
            $sheet->setCellValue("L$row", $load->getTotal($fallSemester));
            $sheet->setCellValue("N$row", $load->getPlanClasses());
            $sheet->setCellValue("O$row", $load->getSelfwork($fallSemester));
            $sheet->setCellValue("P$row", $load->getClasses($fallSemester));
            $sheet->setCellValue("Q$row", $load->getLectures($fallSemester));
            $sheet->setCellValue("S$row", $load->getLabs($fallSemester));
            $sheet->setCellValue("U$row", $load->getPractices($fallSemester));
            $sheet->setCellValue("Y$row", $load->getProject($fallSemester));
            $sheet->setCellValue("Z$row", $load->getCheck($fallSemester));
            $sheet->setCellValue("AA$row", $load->getControl($fallSemester));
            $sheet->setCellValue("AB$row", $load->getControlWorks($fallSemester));
            $sheet->setCellValue("AC$row", $load->getDkk($fallSemester));
            $sheet->setCellValue("AD$row", $load->getConsultation($fallSemester));
            $sheet->setCellValue("AE$row", $load->getExam($fallSemester));
            $sheet->setCellValue("AF$row", $load->getTest($fallSemester));
            $sheet->setCellValue("AG$row", $load->getPay($fallSemester));
            $sheet->setCellValue("AH$row", $load->getTotal($springSemester));
            $sheet->setCellValue("AI$row", $load->getSelfWork($springSemester));
            $sheet->setCellValue("AJ$row", $load->getClasses($springSemester));
            $sheet->setCellValue("AK$row", $load->getLectures($springSemester));
            $sheet->setCellValue("AL$row", $load->getLabs($springSemester));
            $sheet->setCellValue("AM$row", $load->getPractices($springSemester));
            $sheet->setCellValue("AO$row", $load->getProject($springSemester));
            $sheet->setCellValue("AP$row", $load->getCheck($springSemester));
            $sheet->setCellValue("AQ$row", $load->getControl($springSemester));
            $sheet->setCellValue("AR$row", $load->getControlWorks($springSemester));
            $sheet->setCellValue("AS$row", $load->getDkk($springSemester));
            $sheet->setCellValue("AT$row", $load->getConsultation($springSemester));
            $sheet->setCellValue("AU$row", $load->getExam($springSemester));
            $sheet->setCellValue("AV$row", $load->getTest($springSemester));
            $sheet->setCellValue("AW$row", $load->getPay($springSemester));
            $all = $load->getPay($fallSemester) + $load->getPay($springSemester);
            $sheet->setCellValue("AX$row", $all);
            $sheet->setCellValue("AY$row", round($all * $load->getBudgetPercent() / 100));
            $sheet->setCellValue("AZ$row", round($all * $load->getContractPercent() / 100));
            $sheet->getStyle("A$row:AZ$row")->applyFromArray(self::getAllBordersThin());
            $i++;
            $row++;
            $sheet->insertNewRowBefore($row + 1, 1);

        }

        $sheet->setCellValue("D$row", 'Всього');
        $last = $row - 1;

        for ($c = 6; $c < 45; $c++) {
            $index = Coordinate::stringFromColumnIndex($c);
            $sheet->setCellValue("$index$row", "=SUM({$index}6:$index$last)");
        }

        $spreadsheet->setActiveSheetIndex(0);

        return $spreadsheet;
    }
}