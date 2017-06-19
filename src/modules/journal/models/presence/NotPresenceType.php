<?php

namespace app\modules\journal\models\presence;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%not_presence_type}}".
 *
 * @property int $id
 * @property string $title
 * @property string $label
 * @property int $is_great
 * @property int $percent_hours
 * @property int $created_at
 * @property int $updated_at
 */
class NotPresenceType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%not_presence_type}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'label'], 'required'],
            [['is_great', 'percent_hours', 'created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 128],
            [['label'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'label' => Yii::t('app', 'Short title'),
            'is_great' => Yii::t('app', 'Good reason'),
            'greatLabel' => Yii::t('app', 'Good reason'),
            'percent_hours' => Yii::t('app', 'Percent hours'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getGreatLabel()
    {
        return ($this->is_great) ? Yii::t('app', "Yes") : Yii::t('app', 'No');
    }

    public static function getGreatList()
    {
        return [
            0 => Yii::t('app', 'No'),
            1 => Yii::t('app', "Yes"),
        ];
    }
}
