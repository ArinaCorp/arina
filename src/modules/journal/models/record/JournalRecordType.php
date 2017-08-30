<?php

namespace app\modules\journal\models\record;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%journal_record_types}}".
 *
 * @property int $id
 * @property string $title
 * @property int $description
 * @property int $homework
 * @property int $audience
 * @property int $hours
 * @property int $present
 * @property int $date
 * @property int $n_pp
 * @property int $n_in_day
 * @property int $ticket
 * @property int $is_report
 * @property int $report_title
 * @property int $work_type_id
 */
class JournalRecordType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%journal_record_types}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['work_type_id', 'report_title'], 'required', 'when' => function ($model) {
                return $model->is_report == 1;
            }, 'whenClient' => "function (attribute, value) {
                                return $('#journalrecordtype-is_report').checked() == 1;}"],
            [['description', 'homework', 'audience', 'hours', 'present', 'date', 'n_pp', 'n_in_day', 'ticket', 'is_report', 'work_type_id'], 'integer'],
            [['title', 'report_title'], 'string', 'max' => 128],
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
            'description' => Yii::t('app', 'Description'),
            'homework' => Yii::t('app', 'Homework'),
            'audience' => Yii::t('app', 'Audience'),
            'hours' => Yii::t('app', 'Hours'),
            'present' => Yii::t('app', 'Present'),
            'date' => Yii::t('app', 'Date'),
            'n_pp' => Yii::t('app', 'N Pp'),
            'n_in_day' => Yii::t('app', 'N In Day'),
            'ticket' => Yii::t('app', 'Ticket'),
            'is_report' => Yii::t('app', 'Is Report'),
            'report_title' => Yii::t('app', 'Report Title'),
            'work_type_id' => Yii::t('app', 'Work Type ID'),
        ];
    }

    public static function getList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }
}
