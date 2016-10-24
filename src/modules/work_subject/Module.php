<?php

namespace app\modules\wp_subject;

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

    public $controllerNamespace = 'app\modules\work_subject\controllers';

    /**
     * @inheritdoc
     */

    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('app', 'Work subject'),
            'icon' => 'users',
            'items' => [
                [
                    'label' => Yii::t('app', 'List'),
                    'url' => ['/work_subject'],
                    'icon' => 'list',
                ],
            ]
        ];
    }

}
