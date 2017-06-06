<?php

namespace app\helpers;

use Yii;

class PlanHelper
{
    public static function getPlanValue($week, $course)
    {
        $list = self::getDefaultPlan();
        return $list[$course][$week];
    }

    public static function getDefaultWorkPlan($groups)
    {
        $template = self::getDefaultPlan();
        $list = [];
        foreach($groups as $group) {
            $list[]=$template[0];
        }
        return $list;
    }
    /**
     * - T - theoretical training;
     * - S - examination session;
     * - P - practice;
     * - H - vacation (holidays);
     * - E - passing the state exam;
     * - DP - diploma design;
     * - DA - state certification;
     * @return array
     */
    public static function getDefaultPlan()
    {
        return [
            [/** |   September   |   |    October   |    |     November      | */
                'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T',
             /** |    December   |   |     January       |    |   February   | */
                'T', 'T', 'T', 'T', 'H', 'H', 'T', 'T', 'T', 'T', 'T', 'T', 'T',
             /** |     March     |   |     April    |    |         May       | */
                'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T',
             /** |      June     |   |       July        |    |    August    | */
                'T', 'T', 'T', 'T', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H',
            ],
            [/** |   September   |   |    October   |    |     November      | */
                'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T',
             /** |    December   |   |     January       |    |   February   | */
                'T', 'T', 'T', 'S', 'H', 'H', 'T', 'T', 'T', 'T', 'T', 'T', 'T',
             /** |     March     |   |     April    |    |         May       | */
                'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'S', 'S', 'P',
             /** |      June     |   |       July        |    |    August    | */
                'P', 'P', 'P', 'P', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H',
            ],
            [/** |   September   |   |    October   |    |     November      | */
                'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T',
             /** |    December   |   |     January       |    |   February   | */
                'T', 'T', 'T', 'S', 'H', 'H', 'T', 'T', 'T', 'T', 'T', 'T', 'T',
             /** |     March     |   |     April    |    |         May       | */
                'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'S', 'S', 'P',
             /** |      June     |   |       July        |    |    August    | */
                'P', 'P', 'P', 'P', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H', 'H',
            ],
            [/** |   September   |   |    October   |    |     November      | */
                'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T', 'T',
             /** |    December   |   |     January       |    |   February   | */
                'T', 'T', 'T', 'S', 'H', 'H', 'T', 'T', 'T', 'T', 'T', 'T', 'T',
             /** |     March     |   |     April    |    |         May       | */
                'T', 'S', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P','DP', 'DP',
             /** |        June       |  |         July        |  |     August     | */
                'DP', 'DP', 'DP', 'DA', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
            ],
        ];
    }

    /**
     * @param null $index
     * @return array
     */
    public static function getControlTypes($index = NULL)
    {
        $types = [
            0 => Yii::t('plans', 'Test'),
            1 => Yii::t('plans', 'Exam'),
        ];
        if (isset($index))
            return $types[$index];
        else
            return $types;
    }
}