<?php

namespace app\modules\journal\models\reports;

use app\modules\journal\models\record\JournalRecord;
use app\modules\load\models\Load;
use yii\base\Model;
use Yii;
use PHPExcel_IOFactory;

class SubjectReport extends Model
{
    public static function getReport($load_id)
    {
        $load = Load::getZaglushka();
        $tmpfname = Yii::getAlias('@webroot') . "/templates/report_subject.xls";
        $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);;
        $excelObj = $excelReader->load($tmpfname);
        $excelObj->setActiveSheetIndex(0);
        $excelObj->getActiveSheet()->SetCellValue('D2', $load->studyYear->getFullName());
        $excelObj->getActiveSheet()->SetCellValue('D3', $load->workSubject->subject->title);
        $excelObj->getActiveSheet()->SetCellValue('D4', $load->group->title);

        /**
         * @var JournalRecord[] $records
         */
        $records = JournalRecord::getByLoadArray($load_id);
        if (!is_null($records)) {
            $startRow = 7;
            $current = $startRow;
            $i = 1;
            $allCount = 0;
            foreach ($records as $record) {
                $excelObj->getActiveSheet()->getRowDimension($current)->setRowHeight(-1);
                $excelObj->getActiveSheet()->insertNewRowBefore($current + 1);
                if (!is_null($record->number)) {
                    $excelObj->getActiveSheet()->setCellValue('B' . $current, $record->number);
                }
                $allCount += intval($record->hours);
                $excelObj->getActiveSheet()->setCellValue('C' . $current, $record->typeObj->title);
                $excelObj->getActiveSheet()->setCellValue('D' . $current, $record->teacher->fullName);
                $excelObj->getActiveSheet()->setCellValue('E' . $current, intval($record->hours) . '/' . $allCount);
                $excelObj->getActiveSheet()->setCellValue('F' . $current, $record->description);
                $excelObj->getActiveSheet()->setCellValue('G' . $current, $record->home_work);
                $excelObj->getActiveSheet()->setCellValue('H' . $current, $record->date);
                $current++;
            }
            $excelObj->getActiveSheet()->removeRow($current);
            $excelObj->getActiveSheet()->removeRow($current);
            $current += 2;
            $excelObj->getActiveSheet()->setCellValue('F' . $current, Yii::t('app', 'Date created'));
            $excelObj->getActiveSheet()->setCellValue('G' . $current, date('d.m.Y H:i:s'));
        }
        header('Content-Type: application/vnd.ms-excel');
        $filename = "subject_" . $load->getLabelInfo() . "_" . date("d-m-Y-His") . ".xls";
        header('Content-Disposition: attachment;filename=' . $filename . ' ');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($excelObj, 'Excel2007');
        $objWriter->save('php://output');
    }
}