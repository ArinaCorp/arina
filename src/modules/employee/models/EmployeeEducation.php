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

    public static function shortClassName()
    {
        $reflector = new \ReflectionClass(get_called_class());

        return $reflector->getShortName();
    }

    /**
     * @param $employee_id
     * @param $employee
     * @return EmployeeEducation[]|array|\yii\db\ActiveRecord[]
     */
    public static function getList($employee_id, $employee)
    {
        $query = self::find();
        $query->andWhere([
            'employee_id' => $employee_id,
        ]);
        $list = $query->all();
        /**
         * @var $list self[];
         */
        foreach ($list as $key => $employeeEducation) {
            if ($employeeEducation->isNewRecord) {
                $list[$key]->id = null;
            }
        };
        $params = Yii::$app->request->post(self::shortClassName());
        if ($params && is_array($params)) {
            $list = [];
            for ($i = 0; $i < count($params); $i++) {
                $model = new self();
                $model->setAttributes($params[$i]);
                $list[] = $model;
            }
        } elseif (Yii::$app->request->isPost) {
            $list = [];
        }
        if (Yii::$app->request->post('add-' . self::shortClassName())) {
            $list[] = new self();;
        }
        if (Yii::$app->request->post('remove-' . self::shortClassName())) {
            unset($list[Yii::$app->request->post('data-key')]);
            $oldList = $list;
            $list = [];
            foreach ($oldList as $employeeEducation) {
                $list[] = $employeeEducation;
            }
        }
        return $list;
    }
}
