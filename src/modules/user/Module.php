<?php

namespace app\modules\user;

use nullref\core\interfaces\IAdminModule;
use Yii;

/**
 * Class Module
 */
class Module extends \dektrium\user\Module implements IAdminModule
{

    public static function getAdminMenu()
    {
        return [
            'label' => Yii::t('admin', 'Users'),
            'url' => ['/user/admin'],
            'icon' => 'users',
            'order' => 1,
        ];
    }
}