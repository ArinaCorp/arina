<?php
/**
 *
 */


namespace app\modules\user\helpers;


use app\modules\user\models\User;
use rmrevin\yii\fontawesome\FA;
use Yii;
use yii\helpers\ArrayHelper;

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

    /**
     * @param User $user
     * @return array
     * @throws \Exception
     * @throws \Throwable
     */
    public static function getUserFullRoleList(User $user)
    {
        $result = [];

        $roles = self::getRoles($user);
        foreach ($roles as $role) {
            $result = array_merge($result, Yii::$app->authManager->getChildRoles($role->name));
        }

        return ArrayHelper::getColumn($result, 'name');
    }

    /**
     * @param User $user
     * @return \yii\rbac\Role[]
     */
    public static function getRoles(User $user)
    {
        return Yii::$app->authManager->getRolesByUser($user->id);
    }
}
