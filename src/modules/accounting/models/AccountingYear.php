<?php

namespace app\modules\accounting\models;

use Yii;

/**
 * This is the model class for table "accounting_year".
 *
 * @property int $account_id
 * @property int $teacher_id
 * @property int $subject_id
 * @property string $mounth
 */
class AccountingYear extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accounting_year';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['teacher_id', 'subject_id', 'mounth'], 'required'],
            [['teacher_id', 'subject_id'], 'integer'],
            [['mounth'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Account ID',
            'teacher_id' => 'Teacher ID',
            'subject_id' => 'Subject ID',
            'mounth' => 'Mounth',
        ];
    }
}
