<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 01.05.2018
 * Time: 14:39
 */

namespace app\modules\user\models;


use developeruz\db_rbac\interfaces\UserRbacInterface;
use nullref\admin\models\Admin;

class User extends \dektrium\user\models\User implements UserRbacInterface
{

    public function getUserName()
    {
        return $this->username;
    }
}