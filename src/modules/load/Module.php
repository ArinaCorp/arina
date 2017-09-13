<?php

namespace app\modules\load;

use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;

/**
 * plans module definition class
 */
class Module extends BaseModule implements IAdminModule
{

    public function behaviors()
    {
        return [
//            'as AccessBehavior' => [
//                'class' => \developeruz\db_rbac\behaviors\AccessBehavior::className(),
//            ]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\load\controllers';
    public $modelsNamespace = 'app\modules\load\models';

    /**
     * @inheritdoc
     */
    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('load', 'Load'),
            'icon' => 'folder',
            'items' => [
                [
                    'label' => Yii::t('load', 'View loads'),
                    'url' => ['/load/index'],
                    'icon' => 'th-list',
                ],
                [
                    'label' => Yii::t('load', 'Create load'),
                    'url' => ['/load/default/create'],
                    'icon' => 'plus',
                ],
            ]
        ];
    }
}
