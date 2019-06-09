<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2019 NRE
 */


namespace app\modules\plans\components\exceptions;


class Calendar extends \Exception
{
    /**
     * @return Calendar
     */
    public static function cantCreate()
    {
        return new self("Can't create study year");
    }

    /**
     * @return Calendar
     */
    public static function cantGet()
    {
        return new self("Can't get study year");
    }

}