<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 22.05.2017
 * Time: 21:35
 */

namespace app\components;


use yii\base\DynamicModel;

class VkDynamicModel extends DynamicModel
{
    private $_formName;

    public function formName()
    {
        if (empty($this->_formName)) {
            $reflector = new \ReflectionClass($this);
            $this->_formName = $reflector->getShortName();
        }
        return $this->_formName;
    }

    public function setFormName($value) {
        $this->_formName = $value;
    }

    private $_attributeLabels = [];

    public function attributeLabels()
    {
        return $this->_attributeLabels;
    }

    public function setAttributeLabels($attributeLabels)
    {
        $this->_attributeLabels = $attributeLabels;
    }
}