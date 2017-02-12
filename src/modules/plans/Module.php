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
                    'label' => Yii::t('Plans', 'View study plans'),
                    'url' => ['/studyPlans/index'],
                    'icon' => 'list',
                ],

                [
                    'label' => Yii::t('Plans', 'Create study plan'),
                    'url' => ['/studyPlans/create'],
                    'icon' => 'list',
                ],

                [
                    'label' => Yii::t('Plans', 'View work plans'),
                    'url' => ['/workPlans/index'],
                    'icon' => 'list',
                ],

                [
                    'label' => Yii::t('Plans', 'Create work plan'),
                    'url' => ['/workPlans/create'],
                    'icon' => 'list',
                ],
            ]
        ];
    }
}
