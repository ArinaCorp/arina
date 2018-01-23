<?php

namespace app\modules\students\models;

use nullref\useful\traits\Mappable;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%social_networks}}".
 *
 * @property int $id
 * @property string $title
 * @property int $created_at
 * @property int $updated_at
 */
class SocialNetwork extends \yii\db\ActiveRecord
{
    use Mappable;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%social_networks}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 64],
            [['title'], 'required']
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
