<?php
/**
 * @author VasyaKog
 */

namespace app\modules\students\models;


use yii\helpers\ArrayHelper;

class StudentsHistoryPayment extends StudentsHistory
{
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
            [
                [['payment_type'], 'required'],
            ]

        );


    }
}