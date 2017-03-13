<?php
/**
 * @author VasyaKog
 */

namespace app\components;


class DepDropHelper
{
    public static function convertMap($array)
    {
        $result = [];
        if (is_null($array))     return [];
        foreach ($array as $key => $value) $result[] = ['id' => $key, 'name' => $value];
        return $result;
    }
}