<?php
/**
 * @author VasyaKog
 */

namespace app\modules\students\models;


use yii\helpers\ArrayHelper;

class StudentsHistoryAll extends StudentsHistory
{
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
            [
                [['payment_type', 'course', 'group_id', 'speciality_qualification_id'], 'required'],
            ]

        );


    }
}