<?php

namespace app\modules\work_subject;

use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;

/**
 * work subject module definition class
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
            'label' => Yii::t('app', 'Plans'),
            'icon' => 'users',
            'items' => [
                [
                    'label' => Yii::t('app', 'List'),
                    'url' => ['/plans'],
                    'icon' => 'list',
                ],
            ]
        ];
    }
}
