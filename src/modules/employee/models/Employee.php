<?php

namespace app\modules\employee\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "employee".
 * @property integer $id
 * @property integer $is_in_education
 * @property integer $position_id
 * @property integer $category_id
 * @property integer $type
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property integer $gender
 * @property integer $cyclic_commission_id
 * @property string $birth_date
 * @property string $passport
 * @property string $passport_issued_by
 */
class Employee extends ActiveRecord
{
    /** Types */
    const TYPE_NONE = 0;
    const TYPE_TEACHER = 1;
    const TYPE_OTHER = 2;

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%employee}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [['id', 'position_id', 'is_in_education', 'gender', 'type', 'cyclic_commission_id'], 'integer'],
            [['last_name', 'first_name', 'middle_name', 'position_id', 'is_in_education',
                'gender','passport','type'], 'required'],
            [['birth_date','cyclic_commission_id', 'passport', 'passport_issued_by'], 'safe'],
            [['passport', 'id'], 'unique'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('employee', 'ID'),
            'is_in_education' => Yii::t('employee', 'Do teach?'),
            'position_id' => Yii::t('employee', 'Position ID'),
            'category_id' => Yii::t('employee', 'Category iD'),
            'type' => Yii::t('employee', 'Type'),
            'first_name' => Yii::t('employee', 'First name'),
            'middle_name' => Yii::t('employee', 'Middle name'),
            'last_name' => Yii::t('employee', 'Last name'),
            'gender' => Yii::t('employee', 'Gender'),
            'cyclic_commission_id' => Yii::t('employee', 'Cyclic commission'),
            'birth_date' => Yii::t('employee', 'Birth date'),
            'passport' => Yii::t('employee', 'Passport'),
            'passport_issued_by' => Yii::t('employee', 'Passport issued by'),
        ];
    }

    public function getFullName()
    {
        return trim("$this->last_name $this->first_name $this->middle_name");
    }

    public function getNameWithInitials()
    {
        $firstNameInitial = mb_substr($this->first_name, 0, 1, 'UTF-8');
        $middleNameInitial = mb_substr($this->middle_name, 0, 1, 'UTF-8');
        return trim("$this->last_name {$firstNameInitial}. {$middleNameInitial}.");
    }

    public function getShortName()
    {
        return $this->first_name . ' ' . $this->middle_name . ' ' . $this->last_name;
    }

    public static function getTypes()
    {
        return [
            self::TYPE_NONE => Yii::t('employee', 'Nobody'),
            self::TYPE_OTHER => Yii::t('employee', 'Another employee'),
            self::TYPE_TEACHER => Yii::t('employee', 'Teacher'),
        ];
    }

}
