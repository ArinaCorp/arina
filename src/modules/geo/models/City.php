<?php

namespace app\modules\geo\models;

use nullref\core\models\Model as BaseModel;
use nullref\useful\traits\Mappable;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "city".
 *
 * @property integer $id
 * @property string $name
 * @property string $data
 * @property integer $region_id
 * @property integer $country_id
 * @property integer $district_id
 * @property integer $createdAt
 * @property integer $updatedAt
 *
 * @property $region Region
 * @property $country Country
 */
class City extends \tigrov\country\City
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
