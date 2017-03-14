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
            'label' => Yii::t('plans', 'Plans'),
            'icon' => 'folder',
            'items' => [
                [
                    'label' => Yii::t('plans', 'View study plans'),
                    'url' => ['/plans/study-plan/'],
                    'icon' => 'th-list',
                ],
                [
                    'label' => Yii::t('plans', 'Create study plan'),
                    'url' => ['/plans/study-plan/create'],
                    'icon' => 'plus',
                ],
                /*[
                    'label' => Yii::t('plans', 'View work plans'),
                    'url' => ['/plans/work-plan/'],
                    'icon' => 'list',
                ],
                [
                    'label' => Yii::t('plans', 'Create work plan'),
                    'url' => ['/plans/work-plan/create'],
                    'icon' => 'list',
                ],*/
            ]
        ];
    }
}
