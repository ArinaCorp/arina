<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 30.04.2019
 * Time: 12:38
 */

namespace app\modules\load\models;


use nullref\useful\traits\MappableQuery;
use yii\db\ActiveQuery;

class LoadQuery extends ActiveQuery
{
    use MappableQuery;
}