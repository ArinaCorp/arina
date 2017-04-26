<?php
/**
 * @author VasyaKog
 */

namespace app\modules\students\models;


use yii\helpers\ArrayHelper;

class StudentsHistoryCourse extends StudentsHistory
{
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
            [
                [['course'], 'required'],
            ]

        );


    }
}