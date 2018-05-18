<?php

namespace app\modules\admin;

/**
 * admin module definition class
 */
class Module extends \nullref\admin\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
