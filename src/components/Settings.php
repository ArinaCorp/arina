<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 22.05.2017
 * Time: 21:23
 */

namespace app\components;

use yii\base\Component;
use yii\helpers\ArrayHelper;

class Settings extends Component
{
    private $_attributes;

    public function init()
    {
        $this->_attributes = ArrayHelper::map(\backend\modules\main\models\Settings::find()->all(),'field_key','field_value');
    }

    public function __get($name)
    {
        if (isset($this->_attributes[$name])) {
            return $this->_attributes[$name];
        } else {
            return null;
        }
    }
}