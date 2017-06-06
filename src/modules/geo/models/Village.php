<?php

namespace app\modules\geo\models;

use nullref\core\models\Model as BaseModel;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "village".
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
class Village extends BaseModel
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'village';
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
            [['name', 'region_id', 'country_id', 'district_id'], 'required'],
            [['data'], 'safe'],
            [['region_id', 'country_id', 'district_id', 'createdAt', 'updatedAt'], 'integer'],
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
            'region_id' => Yii::t('app', 'Region'),
            'country_id' => Yii::t('app', 'Country'),
            'district_id' => Yii::t('app', 'District'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'region_id']);
    }

    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    public function getDepRegion($country_id)
    {
        $result = [];
        $depRegions = $this->getRegion()->where(['country_id' => $country_id])->all();
        foreach ($depRegions as $key => $region) {
            $result = [
                ['id'=>"<region-id-$key>", 'name'=>"<region-name$key>"]
            ];

        }
        return $result;
    }

    public function getDepDistrict($region_id)
    {
        $result = [];
        $depDistricts = $this->getRegion()->where(['region_id' => $region_id])->all();
        foreach ($depDistricts as $key => $district) {
            $result = [
                ['id'=>"<district-id-$key>", 'name'=>"<district-name$key>"]
            ];

        }
        return $result;
    }

}
