<?php
namespace app\modules\geo\models;

use nullref\core\models\Model as BaseModel;
use nullref\useful\DropDownTrait;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "district".
 *
 * @property integer $id
 * @property string $name
 * @property string $data
 * @property integer $country_id
 * @property integer $region_id
 * @property integer $createdAt
 * @property integer $updatedAt
 *
 * @property Region[] $regions
 * @property City[] $cities
 */
class District extends BaseModel
{
    use DropDownTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'district';
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'timestamp' => [
                'class' => TimestampBehavior::class,
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
            [['name'], 'required'],
            [['data'], 'safe'],
            [['region_id', 'country_id'], 'integer'],
            [['createdAt', 'updatedAt'], 'integer'],
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
            'country_id' => Yii::t('app', 'Country ID'),
            'region_id' => Yii::t('app', 'Region ID'),
            'name' => Yii::t('app', 'Name'),
            'data' => Yii::t('app', 'Data'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'region_id']);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
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
}
