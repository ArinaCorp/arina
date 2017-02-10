<?php

namespace app\modules\plans;

use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;

/**
 * plans module definition class
 */
class Module extends BaseModule implements IAdminModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\plans\controllers';
    public $modelsNamespace = 'app\modules\plans\models';

    /**
     * @inheritdoc
     */
    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('Plans', 'Plans'),
            'icon' => 'users',
            'items' => [
                [
                    'label' => Yii::t('Plans', 'Plans'),
                    'url' => ['/plans'],
                    'icon' => 'list',
                ],
            ]
        ];
    }
}
