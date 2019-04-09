<?php
/**
 * Created by IntelliJ IDEA.
 * User: vladi
 * Date: 24.03.2019
 * Time: 17:31
 */

namespace app\modules\students\models;


use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use yii\helpers\ArrayHelper;

class Filter
{
    public static function getSpecialitiesByDepartmentId($dep_id)
    {
        $specialities = Speciality::findAll(['department_id' => $dep_id]);
        $ids = [];
        foreach ($specialities as $speciality) {
            array_push($ids,$speciality['id']);
        }
        return ArrayHelper::map($ids, 'id', 'title');
    }
}