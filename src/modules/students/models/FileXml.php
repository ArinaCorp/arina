<?php
/**
 * @author VasyaKog
 */

namespace app\modules\students\models;

use Yii;

class FileXml extends \yii\base\Model
{

    public $file;
    public $photos;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['file', 'required'],
            [['file'], 'file', 'extensions' => 'xml'],
            [['photos'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpeg, jpg, gif, png', 'maxFiles' => 90],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'photos' => Yii::t('app', 'Photos'),
            'file' => Yii::t('app', 'Select file from import'),
        ];
    }
}