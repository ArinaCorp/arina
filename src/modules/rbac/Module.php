<?php
/**
 * @author    Velychko Yaroslav
 */

namespace app\modules\rbac;

use app\modules\rbac\interfaces\IAccessibleModule;
use dektrium\rbac\RbacWebModule as BaseModule;
use nullref\core\interfaces\IAdminModule;
use rmrevin\yii\fontawesome\FA;
use Yii;

class Module extends BaseModule implements IAdminModule, IAccessibleModule
{
    public $controllerNamespace = 'app\modules\rbac\controllers';

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
                    'roles' => ['administrator'],
                ],
                [
                    'label' => \Yii::t('rbac', 'Permissions'),
                    'icon' => FA::_HAND_STOP_O,
                    'url' => '/rbac/permission/',
                    'roles' => ['administrator'],
                ],
                [
                    'label' => \Yii::t('rbac', 'Actions access'),
                    'icon' => FA::_HAND_STOP_O,
                    'url' => '/rbac/access/',
                    'roles' => ['administrator'],
                ],

            ]
        ];
    }

    /** @inheritdoc */
    public function behaviors()
    {
        return [];
    }

    /**
     * @return array
     */
    public static function getAccessibleControllerAliases()
    {
        return [
            '@app/modules/rbac/controllers',
            '@dektrium/rbac/controllers',
        ];
    }
}