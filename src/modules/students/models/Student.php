<?php

namespace app\modules\students\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property integer $id
 * @property string $student_code
 * @property integer $sseed_id
 * @property integer $user_id
 * @property string $last_name
 * @property string $first_name
 * @property string $middle_name
 * @property integer $gender
 * @property string $birth_day
 * @property string $passport_code
 * @property string $tax_id
 * @property integer $form_of_study_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sseed_id', 'user_id', 'gender', 'form_of_study_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['last_name', 'first_name', 'middle_name'], 'required'],
            [['birth_day'], 'safe'],
            [['student_code', 'passport_code'], 'string', 'max' => 12],
            [['last_name', 'first_name', 'middle_name'], 'string', 'max' => 255],
            [['tax_id'], 'string', 'max' => 10],
            [['student_code'], 'unique'],
            [['sseed_id'], 'unique'],
            [['user_id'], 'unique'],
            [['passport_code'], 'unique'],
            [['tax_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_code' => 'Student Code',
            'sseed_id' => 'Sseed ID',
            'user_id' => 'User ID',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'gender' => 'Gender',
            'birth_day' => 'Birth Day',
            'passport_code' => 'Passport Code',
            'tax_id' => 'Tax ID',
            'form_of_study_id' => 'Form Of Study ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
