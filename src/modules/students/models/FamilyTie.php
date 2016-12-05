<?php

namespace app\modules\students\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "family_ties".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $type_id
 * @property string $last_name
 * @property string $first_name
 * @property string $middle_name
 * @property string $work_place
 * @property string $work_position
 * @property string $phone1
 * @property string $phone2
 * @property string $email
 * @property integer $created_at
 * @property integer $updated_at
 */
class FamilyTie extends \yii\db\ActiveRecord
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
        return 'family_ties';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'type_id', 'created_at', 'updated_at'], 'integer'],
            [['last_name', 'first_name', 'middle_name', 'type_id'], 'required'],
            [['last_name', 'first_name', 'middle_name', 'work_place', 'work_position', 'phone1', 'phone2', 'email'], 'string', 'max' => 255],
            [['email'], 'email'],
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
            'type_id' => Yii::t('app', 'Type Family Tie'),
            'last_name' => Yii::t('app', 'Last Name'),
            'first_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'work_place' => Yii::t('app', 'Work Place'),
            'work_position' => Yii::t('app', 'Work Position'),
            'phone1' => Yii::t('app', 'Phone'),
            'phone2' => Yii::t('app', 'Phone'),
            'email' => Yii::t('app', 'Email'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getType()
    {
        return $this->hasOne(FamilyTiesType::className(), ['id' => 'type_id']);
    }

    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['student_id' => 'id']);
    }
}
