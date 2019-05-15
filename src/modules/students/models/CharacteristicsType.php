<?php

namespace app\modules\students\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%characteristics_type}}".
 *
 * @property int $id
 * @property string $title
 * @property int $created_at
 * @property int $updated_at
 */
class CharacteristicsType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public static function tableName()
    {
        return '{{%characteristics_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 64],
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
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
