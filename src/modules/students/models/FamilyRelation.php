<?php

namespace app\modules\students\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\BadRequestHttpException;

/**
 * This is the model class for table "family_relation".
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
class FamilyRelation extends \yii\db\ActiveRecord
{
    //TODO: Create a seed migration with these id's for relation_type
    const TYPE_MOTHER = 1,
        TYPE_FATHER = 2,
        TYPE_SPOUSE = 3;

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
        return 'family_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'safe'],
            [['student_id', 'type_id', 'created_at', 'updated_at'], 'integer'],
            [['last_name', 'first_name', 'middle_name', 'type_id'], 'required'],
            [['last_name', 'first_name', 'middle_name', 'work_place', 'work_position'], 'string', 'max' => 255],
            [['email'], 'email'],
            ['phone1', 'match', 'pattern' => '/^\+[0-9]{2} \([0-9]{3}\) ?[0-9]{3}-[0-9]{4}$/'],
            ['phone2', 'match', 'pattern' => '/^\+[0-9]{2} \([0-9]{3}\) ?[0-9]{3}-[0-9]{4}$/'],
            [['phone1', 'phone2'], 'string'],
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
        return $this->hasOne(FamilyRelationType::class, ['id' => 'type_id']);
    }

    public function getStudent()
    {
        return $this->hasOne(Student::class, ['student_id' => 'id']);
    }
}
