<?php
/**
 * Created by PhpStorm.
 * User: wenceslaus
 * Date: 5/21/18
 * Time: 5:22 PM
 */

namespace app\components\exporters;

use app\modules\employee\models\Employee;
use PhpOffice\PhpSpreadsheet;

class EmployeeExporter extends BaseExporter
{
    /**
     * @param $data null
     * @param $optional null
     * @param $spreadsheet PhpSpreadsheet\Spreadsheet
     * @return PhpSpreadsheet\Spreadsheet
     * @throws PhpSpreadsheet\Exception
     */
    public static function getSpreadsheet($spreadsheet, $data = null, $optional = null)
    {
        $spreadsheet->setActiveSheetIndex(0);

        /**
         * @var Employee[] $employees
         */

        $employees = Employee::getList();

        if (!is_null($employees)) {

            foreach (range('A', 'G') as $col) {
                if ($col != 'F')
                    $spreadsheet->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
            }

            $current = 5;
            $i = 1;
            foreach ($employees as $employee) {
                $spreadsheet->getActiveSheet()
                    ->insertNewRowBefore($current + 1)
                    ->setCellValue('B' . $current, $i)
                    ->setCellValue('C' . $current, $employee->getPosition())
                    ->setCellValue('D' . $current, $employee->getFullName())
                    ->setCellValue('E' . $current, $employee->getCyclicCommissionTitle())
                    ->setCellValue('F' . $current, $employee->getStartDate());
                $i++;
                $current++;
            }
            $spreadsheet->getActiveSheet()->removeRow($current);
        }
        return $spreadsheet;

    }

}