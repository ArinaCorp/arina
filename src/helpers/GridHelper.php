<?php

namespace app\helpers;

use app\components\importers\ImportStudent;
use app\modules\students\models\CsvImportDocumentItem;

class GridHelper
{
    /**
     * @return array
     */
    public static function getItemColumns()
    {
        return array_map(function ($column) {
            $target = $column['target'];
            return [
                'label' => $column['label'],
                'value' => function (CsvImportDocumentItem $model) use ($target) {
                    $value = unserialize($model->data)[$target];
                    return isset($value) ? $value : '';
                }
            ];
        }, ImportStudent::getColumns());
    }
}