<?php

namespace app\modules\journal\models\record;

use Yii;

/**
 * This is the model class for table "{{%journal_mark}}".
 *
 * @property int $id
 * @property int $record_id
 * @property int $student_id
 * @property int $presence
 * @property int $not_presence_reason_id
 * @property int $evaluation_system_id
 * @property int $evaluation_id
 * @property string $date
 * @property int $retake_evaluation_id
 * @property string $retake_date
 * @property string $comment
 */
class JournalMark extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%journal_mark}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['record_id', 'student_id'], 'required'],
            [['record_id', 'student_id', 'presence', 'not_presence_reason_id', 'evaluation_system_id', 'evaluation_id', 'retake_evaluation_id'], 'integer'],
            [['date', 'retake_date'], 'safe'],
            [['comment'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'record_id' => Yii::t('app', 'Record ID'),
            'student_id' => Yii::t('app', 'Student ID'),
            'presence' => Yii::t('app', 'Presence'),
            'not_presence_reason_id' => Yii::t('app', 'Not Presence Reason ID'),
            'evaluation_system_id' => Yii::t('app', 'Evaluation System ID'),
            'evaluation_id' => Yii::t('app', 'Evaluation ID'),
            'date' => Yii::t('app', 'Date'),
            'retake_evaluation_id' => Yii::t('app', 'Retake Evaluation ID'),
            'retake_date' => Yii::t('app', 'Retake Date'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }
}
