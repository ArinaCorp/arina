<?php
/**
 * @author VasyaKog
 */

namespace app\modules\students\models;


use yii\helpers\ArrayHelper;

class StudentsHistoryGroup extends StudentsHistory
{
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
            [
                [['group_id'], 'required'],
            ]

        );


    }
}