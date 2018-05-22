<?php
/**
 * Created by PhpStorm.
 * User: wenceslaus
 * Date: 5/21/18
 * Time: 7:36 PM
 */

namespace app\components\exporters;


use app\modules\directories\models\StudyYear;
use app\modules\students\models\Group;
use app\modules\students\models\Student;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yii;

class ExportGroup
{
    /**
     * @param $spreadsheet Spreadsheet
     * @param $group Group
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @return mixed
     */
    public static function getSpreadsheet($spreadsheet, $group)
    {
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()->SetCellValue('B2', $group->title);
        $spreadsheet->getActiveSheet()->SetCellValue('B3', StudyYear::getCurrentYear()->fullName . " навчального року");
        /**
         * @var Student[] $students
         */
        $students = $group->getStudentsArray();
        if (!is_null($students)) {
            $startRow = 7;
            $current = $startRow;
            $i = 1;
            foreach ($students as $student) {
                $spreadsheet->getActiveSheet()->mergeCells("C" . $current . ":G" . $current);
                $spreadsheet->getActiveSheet()->insertNewRowBefore($current + 1);
                $spreadsheet->getActiveSheet()->setCellValue('B' . $current, $i);
                $spreadsheet->getActiveSheet()->setCellValue('C' . $current, $student->getFullName());
                $spreadsheet->getActiveSheet()->setCellValue('H' . $current, $student->getPaymentTypeLabel());
                $i++;
                $current++;
            }
            $spreadsheet->getActiveSheet()->removeRow($current);
            $spreadsheet->getActiveSheet()->removeRow($current);
            $current += 1;
            $spreadsheet->getActiveSheet()->setCellValue('F' . $current, $group->getCuratorShortNameInitialFirst());
            $current += 2;
            $spreadsheet->getActiveSheet()->setCellValue('F' . $current, $group->getGroupLeaderShortNameInitialFirst());
            $current += 2;
            $spreadsheet->getActiveSheet()->setCellValue('F' . $current, Yii::t('app', 'Date created'));
            $spreadsheet->getActiveSheet()->setCellValue('G' . $current, date('d.m.Y H:i:s'));
        }
        return $spreadsheet;
    }
}