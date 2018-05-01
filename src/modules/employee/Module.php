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
    public $controllerAliases = [
        '@app/modules/employee/controllers',
    ];

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\employee\controllers';
    public $modelsNamespace = 'app\modules\employee\models';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
 //               'as AccessBehavior' => [
 //                   'class' => \developeruz\db_rbac\behaviors\AccessBehavior::className(),
 //               ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getAdminMenu()
    {

        return [
            'label' => Yii::t('app', 'Employees'),
            'icon' => 'users',
            'items' => [
                [
                    'label' => Yii::t('app', 'List'),
                    'url' => ['/employee/default/index'],
                    'icon' => 'list',
                ],
                [
                    'label' => Yii::t('app', 'Cyclic Commissions'),
                    'url' => ['/employee/cyclic-commission/index'],
                    'icon' => 'list',
                ],
            ]
        ];
    }
}
