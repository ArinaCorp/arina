<?php
/**
 * @author VasyaKog
 */

namespace app\modules\students\models;
use nullref\core\models\Model;
use \Yii;

class File extends \yii\base\Model
{
    
    public $file;
    public $photos;

    public function rules()
    {
        return [
            ['file','required'],
            [['file'], 'file', 'extensions' => 'xml'],
            [['photos'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpeg, jpg, gif, png','maxFiles' => 90],
        ];
    }

    public function attributeLabels()
    {
        return [
            'file' => Yii::t('app', 'Select file from import'),
        ];
    }
}