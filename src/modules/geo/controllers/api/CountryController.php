<?php

namespace app\modules\geo\controllers\api;
use yii\rest\ActiveController;

class CountryController extends ActiveController
{
    public $modelClass = 'nullref\geo\models\Country';
}