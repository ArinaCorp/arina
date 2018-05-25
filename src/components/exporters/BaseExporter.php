<?php
/**
 * Created by PhpStorm.
 * User: wenceslaus
 * Date: 5/21/18
 * Time: 5:42 PM
 */

namespace app\components\exporters;

use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Yii;

abstract class BaseExporter
{

    abstract public static function getSpreadsheet($spreadsheet, $data);

    /**
     * @var $exporter string - Exporter class name
     * @throws PhpSpreadsheet\Exception
     * @throws PhpSpreadsheet\Reader\Exception
     * @throws PhpSpreadsheet\Writer\Exception
     */
    public static function getDocument($entryData = null)
    {
//        Get module name to load template
        $explodedArray = explode('\\', static::class);
        $className = end($explodedArray);
        $module = str_replace('Exporter', '', $className);

        $template = Yii::getAlias('@webroot') . "/templates/" . strtolower($module) . ".xlsx";
        $spreadsheet = IOFactory::load($template);

//        Fill the spreadsheet and save it
        $spreadsheet = static::getSpreadsheet($spreadsheet, $entryData);

        $filename = $module . "_" . date("d-m-Y-His") . ".xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $filename);
        header('Cache-Control: max-age=0');

        $objWriter = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $objWriter->save('php://output');

        exit();

//        TODO: Make a response return and download exported files to @webroot/exported
//        return Yii::$app->response->sendFile(Yii::getAlias('@webroot') . '/exported/');
    }

    public static function getBorderStyle()
    {
        return [
            'borders' => [
                'allborders' => [
                    'style' => Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
    }

}