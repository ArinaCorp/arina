<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 01.05.2018
 * Time: 14:39
 */

namespace app\modules\user\models;


use app\modules\employee\models\Employee;
use app\modules\students\models\Student;
use dektrium\user\models\User as BaseUser;
use Yii;

/**
 * Class User
 *
 * @property integer $employee_id
 * @property Employee $employee
 * @property Student $student
 *
 * @package app\modules\user\models
 */
class User extends BaseUser
{
    const ROLE_ADMIN = 'admin';
    const ROLE_STUDENT = 'student';
    const ROLE_TEACHER = 'teacher';
    const ROLE_STAFF_OFFICE = 'staff-office';
    const ROLE_HEAD_OF_DEP = 'head-of-department';
    const ROLE_CURATOR = 'curator';
    const ROLE_CYCLIC_COM = 'cyclic-commission';
    const ROLE_HEAD_OF_CYC_COM = 'head-of-cyclic-commission';

    /**
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'employee_id' => ['employee_id', 'integer'],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'employee_id' => \Yii::t('user', 'Employee'),
        ]);
    }


    /**
     * @return \yii\rbac\Role[]
     */
    public function getRoles()
    {
        return Yii::$app->authManager->getRolesByUser($this->id);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::class, ['id'=>'student_id']);
    }
}