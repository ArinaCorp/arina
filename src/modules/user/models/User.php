<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 01.05.2018
 * Time: 14:39
 */

namespace app\modules\user\models;


use app\modules\employee\models\Employee;
use dektrium\user\models\User as BaseUser;
use Yii;

/**
 * Class User
 *
 * @property integer $employee_id
 * @property Employee $employee
 *
 * @package app\modules\user\models
 */
class User extends BaseUser
{
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
}