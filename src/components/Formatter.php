<?php
/**
 */

namespace app\components;


use nullref\useful\helpers\Memoize;
use Yii;
use yii\rbac\Role;

class Formatter extends \yii\i18n\Formatter
{
    /**
     * @param $roles
     * @return string
     */
    public function asRoles($roles)
    {
        $html = '<ul class="list-unstyled">';
        foreach ($roles as $item) {
            $html .= "<li class='badge badge-primary'>" . $this->asRole($item->name) . "</li>";
        }
        $html .= "</ul>";
        return $html;
    }

    /**
     * @param $role
     * @return string
     */
    public static function asRole($role)
    {
        /** @var Role $result */
        $result = Memoize::call([Yii::$app->authManager, 'getRole'], [$role]);
        return $result->description;
    }
}