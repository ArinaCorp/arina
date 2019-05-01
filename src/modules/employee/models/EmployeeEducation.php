<?php

namespace app\modules\employee\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\BadRequestHttpException;

/**
 * This is the model class for table "employee_education".
 *
 * @property int $id
 * @property int $employee_id
 * @property string $name_of_institution
 * @property string $document
 * @property int $graduation_year
 * @property string $speciality
 * @property string $qualification
 * @property string $education_form
 */
class EmployeeEducation extends \yii\db\ActiveRecord
{

    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'employee_education';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_id', 'graduation_year'], 'integer'],
            [['name_of_institution', 'document', 'education_form'], 'required'],
            [['name_of_institution', 'document', 'education_form'], 'string', 'max' => 64],
            [['speciality', 'qualification'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'Employee ID',
            'name_of_institution' => 'Name Of Institution',
            'document' => 'Document',
            'graduation_year' => 'Graduation Year',
            'speciality' => 'Speciality',
            'qualification' => 'Qualification',
            'education_form' => 'Education Form',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['employee_id' => 'id']);
    }
}
