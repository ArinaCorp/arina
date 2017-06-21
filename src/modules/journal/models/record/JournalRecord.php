<?php

namespace app\modules\journal\models\record;

use Yii;

/**
 * This is the model class for table "{{%journal_record}}".
 *
 * @property int $id
 * @property int $load_id
 * @property int $teacher_id
 * @property int $type
 * @property string $date
 * @property string $description
 * @property string $home_work
 * @property int $number
 * @property int $number_in_day
 * @property int $hours
 * @property int $audience_id
 * @property int $created_at
 * @property int $updated_at
 */
class JournalRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%journal_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['load_id', 'teacher_id', 'type', 'number', 'number_in_day', 'hours', 'audience_id'], 'required'],
            [['load_id', 'teacher_id', 'type', 'number', 'number_in_day', 'hours', 'audience_id', 'created_at', 'updated_at'], 'integer'],
            [['date'], 'safe'],
            [['description', 'home_work'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'load_id' => Yii::t('app', 'Load ID'),
            'teacher_id' => Yii::t('app', 'Teacher ID'),
            'type' => Yii::t('app', 'Type'),
            'date' => Yii::t('app', 'Date'),
            'description' => Yii::t('app', 'Description'),
            'home_work' => Yii::t('app', 'Home Work'),
            'number' => Yii::t('app', 'Number'),
            'number_in_day' => Yii::t('app', 'Number In Day'),
            'hours' => Yii::t('app', 'Hours'),
            'audience_id' => Yii::t('app', 'Audience ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public static function getByLoadArray($load_id)
    {
        $records = self::find()
            ->where(['load_id' => $load_id])
            ->orderBy(['date' => SORT_ASC])
            ->all();
        return $records;
    }
}
