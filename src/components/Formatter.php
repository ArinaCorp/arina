<?php
/**
 */

namespace app\components;


use app\modules\user\helpers\UserHelper;

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

    public static function asRole($role)
    {
        $result = UserHelper::getRoleLabels();
        return $result[$role];
    }
}