<?php

namespace app\modules\employee\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

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
            [['id', 'position_id', 'category_id', 'is_in_education', 'gender', 'type', 'cyclic_commission_id'], 'integer'],
            [['last_name', 'first_name', 'middle_name', 'position_id', 'is_in_education',
                'gender', 'passport', 'birth_date', 'passport_issued_by'], 'required'],
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
            'id' => Yii::t('app', 'ID'),
            'is_in_education' => Yii::t('app', 'Do teach?'),
            'position_id' => Yii::t('app', 'Position'),
            'category_id' => Yii::t('app', 'Category'),
            'type' => Yii::t('app', 'Type'),
            'first_name' => Yii::t('app', 'First Name'),
            'middle_name' => Yii::t('app', 'Middle Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'gender' => Yii::t('app', 'Gender'),
            'cyclic_commission_id' => Yii::t('app', 'Cyclic commission'),
            'birth_date' => Yii::t('app', 'Birth Day'),
            'passport' => Yii::t('app', 'Passport Code'),
            'passport_issued_by' => Yii::t('app', 'Passport issued'),
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

    public function getGenderName()
    {
        return $this->gender ? Yii::t('app', 'Female') : Yii::t('app', 'Male');
    }
    
    public function getIsInEducationName()
    {
        return $this->is_in_education ? Yii::t('app', 'Not take part in education') : Yii::t('app', 'Take part in education');
    }

    public static function getList()
    {
        $data = Employee::find()->all();
        $items = ArrayHelper::map($data,'id','nameWithInitials');
        return $items;
    }
    
    

}
