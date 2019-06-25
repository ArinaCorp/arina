<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2019 NRE
 */


namespace app\components\exporters\marks;


use Yii;

class ExportExam extends BaseMarkExporter
{


    public static function getSpreadsheet($spreadsheet, $record)
    {
//        $spreadsheet->setActiveSheetIndex(0);

        $students = self::getStudents($record);
        $marks = self::getMarks($record);
//        $spreadsheet->getActiveSheet()->SetCellValue('B2', $record->typeObj->title);
//        $spreadsheet->getActiveSheet()->SetCellValue('B3', Yii::$app->get('calendar')->getCurrentYear()->fullName . " навчального року");

        if (!is_null($students)) {
//            $startRow = 19;
//            $current = $startRow;
//            $i = 1;
//            foreach ($students as $student) {
//                $spreadsheet->getActiveSheet()->insertNewRowBefore($current + 1);
//                $spreadsheet->getActiveSheet()->mergeCells('B' . $current . ':E' . $current);
//                $spreadsheet->getActiveSheet()->mergeCells('G' . $current . ':H' . $current);
//                $spreadsheet->getActiveSheet()->setCellValue('A' . $current, $i);
//                $spreadsheet->getActiveSheet()->setCellValue('B' . $current, $student->getFullName());
//                if (isset($marks[$student->id])) {
//                    $mark = $marks[$student->id];
//                    $spreadsheet->getActiveSheet()->setCellValue('G' . $current, $mark->value);
//                }
//                $i++;
//                $current++;
//            }
//            $spreadsheet->getActiveSheet()->removeRow($current);
//            $spreadsheet->getActiveSheet()->removeRow($current);
//            $current += 1;
//            $spreadsheet->getActiveSheet()->setCellValue('F' . $current, $group->getCuratorShortNameInitialFirst());
//            $current += 2;
//            $spreadsheet->getActiveSheet()->setCellValue('F' . $current, $group->getGroupLeaderShortNameInitialFirst());
//            $current += 2;
//            $spreadsheet->getActiveSheet()->setCellValue('F' . $current, Yii::t('app', 'Date created'));
//            $spreadsheet->getActiveSheet()->setCellValue('G' . $current, date('d.m.Y H:i:s'));
        }
        return $spreadsheet;
    }
}