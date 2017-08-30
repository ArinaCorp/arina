<?php
namespace app\modules\geo\models;

use nullref\core\models\Model as BaseModel;
use nullref\useful\DropDownTrait;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $data
 * @property integer $createdAt
 * @property integer $updatedAt
 *
 * @property Region[] $regions
 * @property City[] $cities
 */
class Country extends BaseModel
{
    use DropDownTrait;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
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
            [['code', 'name'], 'required'],
            [['data'], 'safe'],
            [['createdAt', 'updatedAt'], 'integer'],
            [['code'], 'string', 'max' => 10],
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
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
            'data' => Yii::t('app', 'Data'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegions()
    {
        return $this->hasMany(Region::className(), ['country_id' => 'id'])->orderBy(['name' => SORT_ASC]);
    }

    public function getCities()
    {
        return $this->hasMany(City::className(), ['country_id' => 'id'])->orderBy(['name' => SORT_ASC]);
    }

}
