<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2018 NRE
 */

namespace app\components;


use app\modules\rbac\models\ActionAccess;
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
        $items['admin']['roles'] = ['dashboard'];

        $items['profile'] = UserHelper::getProfileMenuItems();

        $roles = [];

        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->identity->getId();
            /** @var User $user */
            $user = User::findOne(['id' => $userId]);
            $roles = UserHelper::getUserFullRoleList($user);
        }

        return $this->filterByRole($items, $roles);
    }

    /**
     * @deprecated
     * @param $menu
     * @param array $roles
     * @param string $paramName
     * @return array
     */
    public function filterByRoleArrayByUrl($menu, $roles = [], $paramName = 'url')
    {
        $result = [];

        if (!Yii::$app->user->isGuest) {
            $actions = ActionAccess::find()
                ->with(['authItems'])
                ->asArray()
                ->all();

            $itemsToCheck = [];
            foreach ($actions as $action) {
                $itemToCheck = '/' . $action['module'] . '/' . $action['controller'];
                if ($action['action'] != 'index' && $action['action']) {
                    $itemToCheck .= '/' . $action['action'];
                }
                if ($action['authItems']) {
                    foreach ($action['authItems'] as $authItem) {
                        $itemsToCheck[$authItem['name']] = $itemToCheck;
                    }
                }

            }

            foreach ($menu as $key => $item) {
                if (isset($item['items'])) {
                    $result[$key] = $item;
                    $result[$key]['items'] = $this->filterByRoleArrayByUrl($result[$key]['items'], $roles, $paramName);
                } else {
                    if (isset($item[$paramName])) {
                        $url = (is_array($item[$paramName])) ? array_values($item[$paramName])[0] : $item[$paramName];
                        $url = rtrim($url, '/');
                        if (in_array($url, $itemsToCheck)) {
                            if (in_array(array_search($url, $itemsToCheck), $roles)) {
                                $result[$key] = $item;
                            }
                        } else {
                            $result[$key] = $item;
                        }
                    }
                }
            }
        }

        return $result;
    }

}