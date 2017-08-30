<?php

namespace app\modules\geo\models;

use nullref\core\models\Model as BaseModel;
use nullref\useful\DropDownTrait;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "region".
 *
 * @property integer $id
 * @property string $name
 * @property string $data
 * @property integer $country_id
 * @property integer $createdAt
 * @property integer $updatedAt
 *
 * @property City[] $cities
 *
 * @property $country Country
 */
class Region extends BaseModel
{
    use DropDownTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region';
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'country_id'], 'required'],
            [['data'], 'safe'],
            [['country_id', 'createdAt', 'updatedAt'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'data' => Yii::t('app', 'Data'),
            'country_id' => Yii::t('app', 'Country ID'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['country_id' => 'id'])->orderBy(['name' => SORT_ASC]);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

}
