<?php

namespace app\modules\journal\models\evaluation;

use nullref\useful\traits\Mappable;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%evaluation_systems}}".
 *
 * @property int $id
 * @property string $title
 * @property int $created_at
 * @property int $updated_at
 */
class EvaluationSystem extends \yii\db\ActiveRecord
{
    use Mappable;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%evaluation_systems}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 128],
            ['title', 'unique']
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
