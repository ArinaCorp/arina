<?php

namespace app\modules\load\models;

use Yii;
use yii\db\ActiveRecord;

use app\components\Excel;

class LoadDoc extends ActiveRecord
{
    const TYPE_FULL = 'full';
    const TYPE_BY_TEACHER = 'by_teacher';
    const TYPE_BY_GROUP = 'by_group';
    const TYPE_BY_CYCLIC_COMMISSION = 'by_commission';

    public $type;
    public $study_year_id;
    public $employee_id;
    public $commission_id;
    public $group_id;

    public function setAttributes($values, $safeOnly = true)
    {
        parent::setAttributes($values, $safeOnly);
        $this->setScenario($this->type);
    }

    public function generate()
    {
        $load = array();
        switch ($this->type) {
            case self::TYPE_FULL:
                $load = Load::find()->where(['study_year_id' => $this->study_year_id])->all();
                break;
            case self::TYPE_BY_GROUP:
                $load = Load::find()->where(['study_year_id' => $this->study_year_id, 'group_id' => $this->group_id])->all();
                break;
            case self::TYPE_BY_CYCLIC_COMMISSION:
                $load = Load::find()->where(['study_year_id' => $this->study_year_id])->all();
                break;
            case self::TYPE_BY_TEACHER:
                $load = Load::find()->where(['study_year_id' => $this->study_year_id, 'employee_id' => $this->employee_id])->all();
                break;
        }

        /** @var Excel $excel */
//        $excel = Yii::$app->getComponent('excel');
//        $excel->getDocument($load, 'load');

    }

    public function rules()
    {
        return array(
            array('type', 'required'),
            array('teacherId, commissionId', 'required', 'on' => self::TYPE_BY_TEACHER),
            array('commissionId', 'required', 'on' => self::TYPE_BY_CYCLIC_COMMISSION),
            array('groupId', 'required', 'on' => self::TYPE_BY_GROUP),
        );
    }

    public static function getTypesList()
    {
        return array(
            self::TYPE_FULL => 'Без фільтрів',
            //  self::TYPE_BY_CYCLIC_COMMISSION => 'По цикловій комісії',
            self::TYPE_BY_TEACHER => 'По викладачу',
            self::TYPE_BY_GROUP => 'По групі',
        );
    }

    public function attributeLabels()
    {
        return array(
            'type' => 'Тип',
            'teacherId' => 'Викладач',
            'groupId' => 'Група',
            'commissionId' => 'Циклова комісія',
        );
    }
}