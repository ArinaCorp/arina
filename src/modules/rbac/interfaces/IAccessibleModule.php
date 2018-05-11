<?php
/**
 *
 */


namespace app\modules\rbac\interfaces;


interface IAccessibleModule
{
    public static function getAccessibleControllerAliases();
}