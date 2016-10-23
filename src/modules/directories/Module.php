<?php

namespace app\modules\directories;

use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;

/**
 * directories module definition class
 */
class Module extends BaseModule implements IAdminModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\directories\controllers';


    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('app', 'Directories'),
            'icon' => 'tasks',
            'items' => [    
                [
                    'label' => Yii::t('app', 'Audiences'),
                    'url' => ['/directories/audience'],
                    'icon' => 'folder',
                ],
                [
                    'label' => Yii::t('app', 'Subject'),
                    'url' => ['/directories/subject'],
                    'icon' => 'book',
                ],
            ]
        ];
    }
}
