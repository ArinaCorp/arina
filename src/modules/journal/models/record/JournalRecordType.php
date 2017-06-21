<?php

namespace app\modules\journal\models\record;

use Yii;

/**
 * This is the model class for table "{{%journal_record_types}}".
 *
 * @property int $id
 * @property string $title
 * @property int $description
 * @property int $homework
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
            [['description', 'homework', 'hours', 'present', 'date', 'n_pp', 'n_in_day', 'ticket', 'is_report', 'work_type_id','work_type_id'], 'integer'],
            [['title', 'report_title'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'homework' => 'Homework',
            'hours' => 'Hours',
            'present' => 'Present',
            'date' => 'Date',
            'n_pp' => 'N Pp',
            'n_in_day' => 'N In Day',
            'ticket' => 'Ticket',
            'is_report' => 'Is Report',
            'report_title' => 'Report Title',
            'work_type_id' => 'Work Type ID',
        ];
    }
}
