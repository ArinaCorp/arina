<?php

namespace app\modules\geo\models;

use nullref\useful\traits\Mappable;
use Yii;

/**
 * This is the model class for table "division".
 */
class Region extends \tigrov\country\Division
{
    use Mappable;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [

        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [

        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

        ];
    }
}
