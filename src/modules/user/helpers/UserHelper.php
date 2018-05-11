<?php
/**
 *
 */


namespace app\modules\user\helpers;


use rmrevin\yii\fontawesome\FA;
use Yii;

class UserHelper
{
    public static function getProfileMenuItems()
    {
        return [
            'label' => Yii::t('user', 'Profile'),
            'icon' => FA::_USER,
            'order' => 2,
            'items' => [
                [
                    'label' => Yii::t('user', 'Look at profile'),
                    'icon' => FA::_USER_CIRCLE_O,
                    'url' => '/user/profile/',
                    'roles' => ['access-management'],
                ],
                [
                    'label' => \Yii::t('user', 'Account settings'),
                    'icon' => FA::_USER_SECRET,
                    'url' => '/user/settings/',
                    'roles' => ['access-management'],
                ],

            ]
        ];
    }
}
