<?php

namespace app\modules\employee;

use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;

/**
 * employee module definition class
 */

class Module extends BaseModule implements IAdminModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\employee\controllers';
    public $modelsNamespace = 'app\modules\employee\models';

    /**
     * @inheritdoc
     */
    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('app', 'Employee'),
            'icon' => 'users',
            'items' => [
                [
                    'label' => Yii::t('app', 'List'),
                    'url' => ['/employee'],
                    'icon' => 'list',
                ],
            ]
        ];
    }
}
