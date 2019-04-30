<?php

namespace app\modules\students\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%exemptions_students_relations}}".
 *
 * @property integer $id
 * @property integer $student_id
 * @property integer $exemption_id
 * @property string $date_start
 * @property string $date_end
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Student $student
 * @property Exemption $exemption
 */
class ExemptionStudentRelation extends \yii\db\ActiveRecord
{
    public $group_id;
    public $date_range;

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
        return '{{%exemptions_students_relations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'exemption_id', 'created_at', 'updated_at'], 'integer'],
            [['date_start', 'date_end', 'information'], 'string'],
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
            'group_id' => Yii::t('app', 'Group ID'),
            'exemption_id' => Yii::t('app', 'Exemption title'),
            'exemptionTitle' => Yii::t('app', 'Exemption title'),
            'date_start' => Yii::t('app', 'Start date of exemptions'),
            'date_end' => Yii::t('app', 'End date of exemptions'),
            'date_range' => Yii::t('app', 'Date action'),
            'information' => Yii::t('app', 'Information'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function getExemption()
    {
        return $this->hasOne(Exemption::class, ['id' => 'exemption_id']);
    }

    public function getStudent()
    {
        return $this->hasOne(Student::class, ['id' => 'student_id']);
    }

    public function getStudentFullName()
    {
        return $this->student->getFullNameAndBirthDate();
    }

    public function getExemptionTitle()
    {
        return $this->exemption->title;
    }
}
