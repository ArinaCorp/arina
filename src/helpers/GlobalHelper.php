<?php

namespace app\helpers;

class GlobalHelper
{
    public static function getCurrentYear($number)
    {
        switch ($number) {
            case 1: return date('Y', time())-1;
            case 2: return date('Y', time());
            default: return NULL;
        }
    }

    public static function getWeeksByMonths()
    {
        return array(
            'September'=>4,
            'October'=>4,
            'November'=>5,
            'December'=>4,
            'January'=>5,
            'February'=>4,
            'March'=>4,
            'April'=>4,
            'May'=>5,
            'June'=>4,
            'July'=>5,
            'August'=>4,
        );
    }
}