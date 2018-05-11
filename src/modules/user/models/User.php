<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 01.05.2018
 * Time: 14:39
 */

namespace app\modules\user\models;


use app\modules\rbac\models\AuthAssignment;
use dektrium\user\models\User as BaseUser;
use Yii;
use yii\db\Query;

class User extends BaseUser
{
    /**
     * @return mixed
     */
    public function getRoles()
    {
        $roles = AuthAssignment::find()
            ->select(['item_name'])
            ->where(['user_id' => $this->id])
            ->asArray()
            ->column();

        $result = array_reduce($roles, function ($list, $role) {
            $list = array_merge(User::getItems($role), $list, [$role]);
            return $list;
        }, []);

        return $result;
    }


    /**
     * @param $item
     * @return array|mixed
     * @throws \Exception
     * @throws \Throwable
     */
    public static function getItems($item)
    {
        $children = Yii::$app->db->cache(function () use ($item) {
            $query = new Query();
            return $query->select(['child'])
                ->from(Yii::$app->authManager->itemChildTable)
                ->where(['parent' => $item])
                ->column();
        });

        foreach ($children as $parent) {
            $children = array_merge(self::getItems($parent), $children);
        }
        return $children;
    }

}