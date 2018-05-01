<?php
/**
 * @author    Velychko Yaroslav
 */

namespace app\modules\rbac;

use dektrium\rbac\RbacWebModule as BaseModule;
use nullref\core\interfaces\IAdminModule;
use rmrevin\yii\fontawesome\FA;
use Yii;

class Module extends BaseModule implements IAdminModule
{
    public $controllerAliases = [
        '@app/modules/rbac/controllers',
        '@dektrium/rbac/controllers',
    ];

    public $controllerNamespace = 'dektrium\rbac\controllers';

    public $enableFlashMessages = true;

    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('rbac', 'Access control'),
            'icon' => FA::_WRENCH,
            'order' => 6,
            'items' => [
                [
                    'label' => Yii::t('rbac', 'Roles'),
                    'icon' => FA::_CHILD,
                    'url' => '/rbac/role/',
                    'roles' => ['access-management'],
                ],
                [
                    'label' => \Yii::t('rbac', 'Permissions'),
                    'icon' => FA::_HAND_STOP_O,
                    'url' => '/rbac/permission/',
                    'roles' => ['access-management'],
                ],
                [
                    'label' => \Yii::t('rbac', 'Actions access'),
                    'icon' => FA::_HAND_STOP_O,
                    'url' => '/rbac/access/',
                ],

            ]
        ];
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [];
    }

}