<?php

namespace app\modules\accounting\models;

use Yii;

/**
 * This is the model class for table "accounting".
 *
 * @property int $acc_id
 * @property int $group_id
 * @property int $subject_id
 * @property int $teacher_id
 */
class AccountingMounth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accounting_mounth';
    }

    /**
     * @inheritdoc
     */
   /* public function getStudentsList()
    {
        $array = $this->getStudentsArray();
        $result = [];
        foreach ($array as $item) {
            $result[$item->id] = $item->getFullNameAndCode();
        }
        return $result;
    }*/
    public function rules()
    {
        return [
            [['group_id', 'subject_id', 'teacher_id','date', 'hours'], 'required'],
            [['group_id', 'subject_id', 'teacher_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№ запису',
            'group_id' => 'Група',
            'subject_id' => 'Предмет',
            'teacher_id' => 'Викладач',
            'date' => 'Дата',
            'hours' => 'Години',
        ];
    }
}
