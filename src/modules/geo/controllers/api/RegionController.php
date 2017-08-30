<?php

namespace app\modules\geo\controllers\api;
use yii\rest\ActiveController;

class RegionController extends ActiveController
{
    public $modelClass = 'nullref\geo\models\Region';
}