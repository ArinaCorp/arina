<?php

namespace app\modules\directories\models;

/**
 * This is the model class for table "speciality".
 *
 * @property integer $id
 * @property string $title
 * @property integer $department_id
 * @property string $department
 * @property integer $number
 * @property string $accreditation_date
 */
class Speciality extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'speciality';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_id', 'number'], 'integer'],
            [['accreditation_date'], 'safe'],
            [['title', 'department'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'department_id' => 'Department ID',
            'department' => 'Department',
            'number' => 'Number',
            'accreditation_date' => 'Accreditation Date',
        ];
    }

    /**
     * @inheritdoc
     * @return SpecialityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SpecialityQuery(get_called_class());
    }
}
