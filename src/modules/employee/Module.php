<?php

namespace app\modules\employee;

use app\modules\rbac\interfaces\IAccessibleModule;
use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;

/**
 * employee module definition class
 */
class Module extends BaseModule implements IAdminModule, IAccessibleModule
{
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
                    'roles' => ['staff-office'],
                ],
                [
                    'label' => Yii::t('app', 'Cyclic Commissions'),
                    'url' => ['/employee/cyclic-commission/index'],
                    'icon' => 'list',
                    'roles' => ['staff-office'],
                ],
            ],
            'roles' => ['staff-office'],
        ];
    }

    /**
     * @return array
     */
    public static function getAccessibleControllerAliases()
    {
        return [
            '@app/modules/employee/controllers',
        ];
    }
}
