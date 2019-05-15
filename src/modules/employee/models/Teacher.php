<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2018 NRE
 */


namespace app\modules\employee\models;


use yii\helpers\ArrayHelper;

/**
 * @TODO move active features to Employee model
 * Class Teacher
 * @package app\modules\employee\models
 */
class Teacher extends Employee
{
    public static function getListByCycle($id)
    {
        /** @var CyclicCommission|null $model */
        $model = CyclicCommission::findOne($id);
        if ($model) {
            return ArrayHelper::map($model->teachers, 'id', 'fullName');
        }
        return [];
    }

    /**
     * @return array for dropDownList
     */
    public static function getList()
    {
        return ArrayHelper::map(self::findAll(['order' => 'last_name, middle_name, first_name']), 'id', 'fullName');
    }

    public static function getAll()
    {
        $model = self::find()->all();
        return ArrayHelper::map($model, 'id', 'fullName');
    }

    public static function getTreeList()
    {
        $list = array();
        /**
         * @var CyclicCommission[] $commission
         */
        $commission = CyclicCommission::findAll([]);
        foreach ($commission as $item) {
            $list[$item->title] = array();
            foreach ($item->teachers as $teacher) {
                $list[$item->title][$teacher->id] = $teacher->getFullName();
            }
        }
        return $list;
    }

    public function getCyclicCommissionName()
    {
        return $this->cyclicCommission->title;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('last_name, first_name, middle_name, cyclic_commission_id', 'required'),
            array('cyclic_commission_id', 'numerical', 'integerOnly' => true),
            array('last_name, first_name, middle_name, short_name', 'length', 'max' => 25),
            array('id, last_name, first_name,  middle_name, cyclic_commission_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @TODO rework it
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'group' => array(self::HAS_ONE, 'Group', 'curator_id'),
            'attestations' => array(self::HAS_MANY, 'Attestation', 'teacher_id'),
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCyclicCommission()
    {
        return $this->hasOne(CyclicCommission::class, ['id' => 'cyclic_commission_id']);
    }


    function defaultScope()
    {
        return array(
            'condition' => "participates_in_study_process=1",
        );
    }

}