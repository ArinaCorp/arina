<?php

namespace app\modules\students\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%students_phones}}".
 *
 * @property integer $id
 * @property integer $student_id
 * @property string $phone
 * @property string $comment
 * @property integer $created_at
 * @property integer $updated_at
 */
class StudentsPhone extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%students_phones}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'created_at', 'updated_at'], 'integer'],
            ['phone', 'match', 'pattern' => '/^\+[0-9]{2} \([0-9]{3}\) ?[0-9]{3}-[0-9]{4}$/'],
            [['phone'], 'string'],
            [['phone'], 'required'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'student_id' => Yii::t('app', 'Student ID'),
            'phone' => Yii::t('app', 'Phone'),
            'comment' => Yii::t('app', 'Comment'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->phone;
    }
}
