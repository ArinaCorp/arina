<?php
/**
 * Created by PhpStorm.
 * User: wenceslaus
 * Date: 5/21/18
 * Time: 5:42 PM
 */

namespace app\components;

use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Yii;

class ExportToExcel
{
    /**
     * @param $module - Module Name
     * @var $exporter string - Exporter class name
     * @var $dir string - subdir for exporter
     * @throws PhpSpreadsheet\Exception
     * @throws PhpSpreadsheet\Reader\Exception
     * @throws PhpSpreadsheet\Writer\Exception
     */
    public static function getDocument($module, $entryData = null, $dir = '')
    {
        $module = ucfirst(strtolower($module));
        $exporter = 'app\components\exporters\Export' . $module;
        if ($dir) {
            $exporter = 'app\components\exporters\\' . $dir . '\Export' . $module;
        }
        if (class_exists($exporter)) {
            $tmpfname = Yii::getAlias('@webroot') . "/templates/$dir/" . strtolower($module) . ".xlsx";
            $spreadsheet = IOFactory::load($tmpfname);
            if (is_null($entryData)) {
                $spreadsheet = $exporter::getSpreadsheet($spreadsheet);
            } else {
                $spreadsheet = $exporter::getSpreadsheet($spreadsheet, $entryData);
            }
            $filename = $module . "_" . date("d-m-Y-His") . ".xlsx";
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename=' . $filename);
            header('Cache-Control: max-age=0');
            $objWriter = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $objWriter->save('php://output');
        }
        Yii::$app->end();
    }

    public static function getBorderStyle()
    {
        return [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
    }
}