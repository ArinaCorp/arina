<?php

namespace app\modules\journal\models\record;

use Yii;

/**
 * This is the model class for table "{{%journal_student}}".
 *
 * @property int $id
 * @property int $load_id
 * @property int $student_id
 * @property int $type
 * @property string $date
 * @property int $created_at
 * @property int $updated_at
 */
class JournalStudent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%journal_student}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['load_id', 'student_id', 'type'], 'required'],
            [['load_id', 'student_id', 'type', 'created_at', 'updated_at'], 'integer'],
            [['date'], 'safe'],
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
            'student_id' => Yii::t('app', 'Student ID'),
            'type' => Yii::t('app', 'Type'),
            'date' => Yii::t('app', 'Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
