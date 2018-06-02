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
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yii;

// TODO: Get Zaglushka

class GroupExporter extends BaseExporter
{
//    Optional headers
    public static $headers = ['Phone' => 'Телефон', 'BirthDay' => 'Дата Народження', 'PaymentTypeLabel' => 'Тип оплати'];
    /**
     * @param $spreadsheet Spreadsheet
     * @param $group Group - is a model
     * @param $optional - optional properties
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @return mixed
     */

    public static function getSpreadsheet($spreadsheet, $group, $optional = null)
    {
        $spreadsheet->setActiveSheetIndex(0);
        $sheet=$spreadsheet->getActiveSheet();
        $sheet->SetCellValue('B2', $group->title);
        $sheet->SetCellValue('B3', StudyYear::getCurrentYear()->fullName . " навчального року");
        /**
         * Optional attributes headers
         *
         * @var $header_col - Defines the column after the header cell, we insert columns before it.
         * @var $header_row - Defines the header row.
         * @var $col_inc - Column increment
         * @var $str_inc - Column increment converted to string
         */
        $header_col = 'H';
        $header_row = 4;
        $col_inc = Coordinate::columnIndexFromString($header_col);
        foreach ($optional as $key => $property) {
            if ($property) {
                $str_inc=Coordinate::stringFromColumnIndex($col_inc);
                $sheet->insertNewColumnBefore($str_inc);
                $sheet->setCellValue($str_inc . $header_row, self::$headers[$key]);
                $sheet->getStyle($str_inc . $header_row)->applyFromArray(self::getLeftBorderThin());
                $sheet->getColumnDimension($str_inc)->setAutoSize(true);
                $col_inc++;
            }
        }
        /**
         * @var Student[] $students
         */
        $students = $group->getStudentsArray();
        if (!is_null($students)) {
            $startRow = $header_row+1;
            $currentRow = $startRow;
            $i = 1;
            foreach ($students as $student) {
//                Obligatory cells
                $sheet->mergeCells("C" . $currentRow . ":G" . $currentRow);
                $sheet->insertNewRowBefore($currentRow + 1);
                $sheet->setCellValue('B' . $currentRow, $i);
                $sheet->setCellValue('C' . $currentRow, $student->getFullName());
//                Optional fields
                /**
                 * Optional attributes cells
                 */
                $col_inc = Coordinate::columnIndexFromString($header_col);
                foreach ($optional as $key => $property) {
                    if ($property) {
//                        TODO: Need a way to get the phone number of a student
//                        if ($key = 'telephone')
//                            $sheet->setCellValue($header_col . $currentRow, $student->phones[0]);
//                        else
                        $str_inc = Coordinate::stringFromColumnIndex($col_inc);
                        $getMethod = 'get' . $key;

                        $sheet->setCellValue($str_inc . $currentRow, $student->$getMethod());
                        $sheet->getStyle($str_inc.$currentRow)->applyFromArray(self::getAlignmentCenter());
                        $sheet->getStyle($str_inc . $currentRow)->applyFromArray(self::getLeftBorderThin());
                        $col_inc++;
                    }
                }
                $i++;
                $currentRow++;
            }
            $sheet->removeRow($currentRow);
            $sheet->removeRow($currentRow);
            $currentRow += 1;
            $sheet->setCellValue('F' . $currentRow, $group->getCuratorShortNameInitialFirst());
            $currentRow += 2;
            $sheet->setCellValue('F' . $currentRow, $group->getGroupLeaderShortNameInitialFirst());
            $currentRow += 2;
            $sheet->setCellValue('F' . $currentRow, Yii::t('app', 'Date created'));
            $sheet->setCellValue('G' . $currentRow, date('d.m.Y H:i:s'));
        }
        return $spreadsheet;
    }
}