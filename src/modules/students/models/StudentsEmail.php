<?php

namespace app\modules\students\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\BadRequestHttpException;

/**
 * This is the model class for table "{{%students_emails}}".
 *
 * @property integer $id
 * @property integer $student_id
 * @property string $email
 * @property integer $created_at
 * @property integer $updated_at
 */
class StudentsEmail extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%students_emails}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'created_at', 'updated_at'], 'integer'],
            [['email'], 'email'],
            [['email'], 'required']
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
            'email' => Yii::t('app', 'Email'),
            'comment' => Yii::t('app', 'Comment'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

}
