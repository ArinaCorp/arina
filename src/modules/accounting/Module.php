<?php

namespace app\modules\accounting;

use app\modules\rbac\interfaces\IAccessibleModule;
use nullref\core\interfaces\IAdminModule;
use Yii;
use yii\base\Module as BaseModule;

/**
 * accounting module definition class
 */
class Module extends BaseModule implements IAdminModule, IAccessibleModule
{

    public function behaviors()
    {
        return [
            // 'as AccessBehavior' => [
            //     'class' => \developeruz\db_rbac\behaviors\AccessBehavior::class,
            //  ]
        ];
    }

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\accounting\controllers';

    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('app', 'Accounting'),
            'icon' => 'sticky-note',
            'items' => [
                [
                    'label' => Yii::t('app', 'Yearly hour accounting'),
                    'url' => ['/accounting/yearly-hour-accounting'],
                    'icon' => 'list',
                ],
            ],
            'roles' => ['teacher'],
        ];
    }

    /**
     * @return array
     */
    public static function getAccessibleControllerAliases()
    {
        return [
            '@app/modules/accounting/controllers',
        ];
    }
}
