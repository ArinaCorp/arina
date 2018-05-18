<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2018 NRE
 */

namespace app\components;


use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use nullref\admin\components\MenuBuilder as BaseMenuBuilder;
use Yii;


class MenuBuilder extends BaseMenuBuilder
{
    /**
     * Modify menu items
     *
     * @param array $items
     * @return array
     * @throws \Exception
     * @throws \Throwable
     */
    public function build($items)
    {
        /** Move geo module to directories section */
        $items['directories']['items'][] = $items['geo'];
        unset($items['geo']);


        $items['admin']['url'] = '/';
        $items['admin']['roles'] = ['@'];

        $items['profile'] = UserHelper::getProfileMenuItems();

        $roles = [];

        if (!Yii::$app->user->isGuest) {
            /** @var User $user */
            $user = Yii::$app->user->identity;
            if ($user->isAdmin) {
                return $items;
            }
            $roles = array_values(UserHelper::getUserFullRoleList($user));
        }

        return $this->filterByRoles($items, $roles);
    }

    /**
     * Filter menu items by specified roles
     *
     * @param array $menu
     * @param array $roles
     * @return array
     */
    public function filterByRoles(array $menu, array $roles)
    {
        if ($roles === null) {
            return [];
        }
        $result = [];
        foreach ($menu as $key => $item) {
            $allow = false;
            if (isset($item['roles'])) {
                $itemRoles = $item['roles'];
                if (is_array($itemRoles)) {
                    if (count(array_intersect($roles, $itemRoles)) || in_array('@', $itemRoles)) {
                        $allow = true;
                    }
                }
            }
            if ($allow) {
                if (isset($item['items'])) {
                    $result[$key] = $item;
                    $result[$key]['items'] = $this->filterByRoles($result[$key]['items'], $roles);
                } else {
                    $result[$key] = $item;
                }
            }
        }
        return $result;
    }

}