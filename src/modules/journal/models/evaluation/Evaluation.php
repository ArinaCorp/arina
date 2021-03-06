<?php

namespace app\modules\journal\models\evaluation;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%evaluations}}".
 *
 * @property int $id
 * @property int $system_id
 * @property string $value
 * @property int $created_at
 * @property int $updated_at
 *
 * @property EvaluationSystem $system
 */
class Evaluation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%evaluations}}';
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
            [['system_id', 'value'], 'required'],
            [['system_id', 'created_at', 'updated_at'], 'integer'],
            [['system_id', 'value'], 'unique', 'targetAttribute' => ['system_id', 'value']],
            [['value'], 'string', 'max' => 128],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'system_id' => Yii::t('app', 'Evaluation system'),
            'value' => Yii::t('app', 'Value'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystem()
    {
        return $this->hasOne(EvaluationSystem::class, ['id' => 'system_id']);
    }

    public function getSystemLabel()
    {
        return $this->system->title;
    }

    public static function getArrayBySystem($system_id)
    {
        return self::find()->where(['system_id' => $system_id])->all();
    }

    public static function getListBySystem($system_id)
    {
        return ArrayHelper::map(self::getArrayBySystem($system_id), 'id', 'value');
    }
}
