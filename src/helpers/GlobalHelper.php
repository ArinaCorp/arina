<?php

namespace app\helpers;

use Yii;

class GlobalHelper
{
    public static function getCurrentYear($number)
    {
        switch ($number) {
            case 1:
                return date('Y', time()) - 1;
            case 2:
                return date('Y', time());
            default:
                return NULL;
        }
    }

    public static function getWeeksByMonths()
    {
        return [
            'September' => 4,
            'October' => 4,
            'November' => 5,
            'December' => 4,
            'January' => 5,
            'February' => 4,
            'March' => 4,
            'April' => 4,
            'May' => 5,
            'June' => 4,
            'July' => 5,
            'August' => 4,
        ];
    }

    /**
     * Returns a number literal, duh
     * @param $number int
     * @param null $lang Language
     * @return mixed
     */
    public static function getNumberLiteral($number, $lang = null)
    {
        return Yii::t('number', [
            '1' => 'One',
            '2' => 'Two',
            '3' => 'Three',
            '4' => 'Four',
            '5' => 'Five',
            '6' => 'Six',
            '7' => 'Seven',
            '8' => 'Eight',
            '9' => 'Nine',
            '10' => 'Ten',
            '11' => 'Eleven',
            '12' => 'Twelve',
        ][$number], [], $lang);
    }

    /**
     * Returns the national scale for a mark value
     * 0 - no match
     * 1 - uncompleted/unfair
     * 2 - unsatisfiable
     * 3 - satisfiable
     * 4 - good
     * 5 - excellent
     * @param $mark int
     * @param $evalSystemId int
     * @return string
     */
    public static function getMarkScale($mark, $evalSystemId)
    {
        // Five-level system is equal to the scale, In both systems mark 1 equals scale 1
        if ($evalSystemId == 1 || $mark == 1) {
            return $mark;
        }

        // Twelve-level system
        if ($evalSystemId == 2) {
            if ($mark < 4) {
                return 2;
            } elseif ($mark < 7) {
                return 3;
            } elseif ($mark < 10) {
                return 4;
            } elseif ($mark < 13) {
                return 5;
            }
        }

        // No match
        return 0;
    }

    public static function getMarkScaleLiteral($mark, $evalSystemId, $lang = null)
    {
        return Yii::t('number', [
            '0' => 'ERR?',
            '1' => 'Uncompleted/Unfair',
            '2' => 'Unsatisfiable',
            '3' => 'Satisfiable',
            '4' => 'Good',
            '5' => 'Excellent',
        ][self::getMarkScale($mark, $evalSystemId)], [], $lang);
    }

    /**
     * Return an order literal.
     * @param $orderNumber integer Order number
     * @param $lang string Language to return
     * @return mixed|string
     */
    public static function getOrderLiteral($orderNumber, $lang = null)
    {
        return Yii::t('number', [
            '1' => 'First',
            '2' => 'Second',
            '3' => 'Third',
            '4' => 'Fourth',
            '5' => 'Fifth',
            '6' => 'Sixth',
            '7' => 'Seventh',
            '8' => 'Eighth',
        ][$orderNumber], [], $lang);
    }
}