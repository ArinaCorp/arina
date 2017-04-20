<?php
/**
 * @author VasyaKog
 */

namespace app\modules\students\models;
use nullref\core\models\Model;
use \Yii;

class FileExcel extends \yii\base\Model
{
    
    public $file;

    public function rules()
    {
        return [
            ['file','required'],
            [['file'], 'file', 'extensions' => 'xls'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => Yii::t('app', 'Select file from import'),
        ];
    }
}