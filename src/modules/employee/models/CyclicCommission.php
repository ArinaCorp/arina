<?php

namespace app\modules\employee\models;

use app\modules\directories\models\cyclic_commission\CyclicCommission as BaseCyclicCommission;
use nullref\useful\traits\Mappable;
use PHPExcel_IOFactory;
use Yii;

/**
 * This is the model class for table "cyclic_commission".
 *
 * @property integer $id
 * @property string $title
 * @property integer $head_id
 * @property Employee $head
 */
class CyclicCommission extends BaseCyclicCommission
{
    use Mappable;

    /**
     * @TODO move it
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     */
    public function getDocument()
    {
        $tmpfname = Yii::getAlias('@webroot') . "/templates/cyclic_commission.xls";
        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);;
        $excelObj = $excelReader->load($tmpfname);
        $excelObj->setActiveSheetIndex(0);

        /**
         * @var Employee[] $employees
         */
        $employees = Employee::getAllTeacher($this->id);
        $excelObj->getActiveSheet()->SetCellValue('B2', "Циклова комісія " . $this->title);
        if (!is_null($employees)) {
            $startRow = 5;
            $current = $startRow;
            $i = 1;
            foreach ($employees as $employee) {
                $excelObj->getActiveSheet()->mergeCells("C" . $current . ":D" . $current);
                $excelObj->getActiveSheet()->mergeCells("E" . $current . ":I" . $current);

                $excelObj->getActiveSheet()->insertNewRowBefore($current + 1);
                $excelObj->getActiveSheet()->setCellValue('B' . $current, $i);
                $excelObj->getActiveSheet()->setCellValue('C' . $current, $employee->getPosition());
                $excelObj->getActiveSheet()->setCellValue('E' . $current, $employee->getFullName());
                $i++;
                $current++;
            }
            $excelObj->getActiveSheet()->removeRow($current);
        }
        header('Content-Type: application/vnd.ms-excel');
        $filename = "Cyclic_Commission_" . $this->title . "_" . date("d-m-Y-His") . ".xls";
        header('Content-Disposition: attachment;filename=' . $filename . ' ');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($excelObj, 'Excel2007');
        $objWriter->save('php://output');
    }


}
