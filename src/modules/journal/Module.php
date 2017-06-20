<?php

namespace app\modules\journal;

use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;

/**
 * journal module definition class
 */
class Module extends BaseModule implements IAdminModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\journal\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('app', 'Journal'),
            'icon' => 'users',
            'items' => [
                [
                    'label' => Yii::t('app', 'Evaluation systems'),
                    'url' => ['/journal/evaluation-systems'],
                    'icon' => 'tag',
                ],
                [
                    'label' => Yii::t('app', 'Evaluations'),
                    'url' => ['/journal/evaluations'],
                    'icon' => 'tags',
                ],
                [
                    'label' => Yii::t('app', 'Not presence'),
                    'url' => ['/journal/presence-type'],
                    'icon' => 'list',
                ],
                [
                    'label' => Yii::t('app', 'Journal pages'),
                    'url' => ['/journal'],
                    'icon' => 'icon',
                ],
            ]
        ];
    }
}
