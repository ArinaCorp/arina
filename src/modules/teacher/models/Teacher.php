<?php

namespace app\modules\teacher\models;

use Yii;
use app\modules\employee\models\Employee;
use app\modules\directories\models\cyclic_commission\CyclicCommission;


/**
 * This is the model class for table "teacher".
 *
 * The followings are the available columns in table 'teacher':
 * @property integer $id
 * @property string $last_name
 * @property string $first_name
 * @property string $middle_name
 * @property string $short_name
 * @property integer $cyclic_commission_id
 *
 *
 * @property CyclicCommission $cyclicCommission
 */
class Teacher extends Employee
{

    /**
     * @inheritdoc
     * @return array validation rules for model attributes.
     */

    public function rules()
    {
        return [
            [['last_name', 'first_name', 'middle_name', 'cyclic_commission_id'], 'required'],
            [['cyclic_commission_id'], 'integer'],
            [['last_name', 'first_name', 'middle_name', 'short_name'], 'string', 'max' => 255],
            [['id', 'last_name', 'first_name', 'middle_name', 'cyclic_commission_id'], 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'last_name' => Yii::t('teacher', 'Last Name'),
            'first_name' => Yii::t('teacher', 'First Name'),
            'middle_name' => Yii::t('teacher', 'Middle Name'),
            'short_name' => Yii::t('teacher', 'Short name'),
            'cyclic_commission_id' => Yii::t('teacher', 'Cyclic Commission'),
        ];
    }

    public function getCyclicCommission()
    {
        return $this->hasOne(CyclicCommission::className(), ['id' => 'cyclic_commission_id']);
    }

}