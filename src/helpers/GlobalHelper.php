<?php

namespace app\helpers;

use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
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

    /**
     * Return an according course for given semester(on scale of 8~ semesters)
     * @param $semester
     * @return mixed
     */
    public static function getCourseForSemester($semester)
    {
        $semToCourse = [
            1 => 1,
            2 => 1,
            3 => 2,
            4 => 2,
            5 => 3,
            6 => 3,
            7 => 4,
            8 => 4,
        ];
        return $semToCourse[$semester];
    }

    public static function getAppName()
    {
        $name = Yii::$app->name;

        /** @var User $user */
        $user = Yii::$app->user->identity;
        if ($user) {
            $profileName = '';
            switch ($user) {
                case UserHelper::hasRole($user, 'admin'):
                    $profileName = Yii::t('app', 'Admin profile');
                    break;
                case UserHelper::hasRole($user, 'student'):
                    $profileName = Yii::t('app', 'Student profile');
                    break;
                case UserHelper::hasRole($user, 'teacher'):
                    $profileName = Yii::t('app', 'Teacher profile');
                    break;
            }

            $name .= " – $profileName";
        }
        return $name;
    }
}