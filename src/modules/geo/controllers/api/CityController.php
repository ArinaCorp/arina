<?php

namespace app\modules\geo\controllers\api;
use yii\rest\ActiveController;


class CityController extends ActiveController
{
    public $modelClass = 'nullref\geo\models\City';
}