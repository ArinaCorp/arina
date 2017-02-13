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
        $list = array();
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
            [
                'T', //1
                'T', //2
                'T', //3
                'T', //4
                'T', //5
                'T', //6
                'T', //7
                'T', //8
                'T', //9
                'T', //10
                'T', //11
                'T', //12
                'T', //13
                'T', //14
                'T', //15
                'T', //16
                'T', //17
                'H', //18
                'H', //19
                'T', //20
                'T', //21
                'T', //22
                'T', //23
                'T', //24
                'T', //25
                'T', //26
                'T', //27
                'T', //28
                'T', //29
                'T', //30
                'T', //31
                'T', //32
                'T', //33
                'T', //34
                'T', //35
                'T', //36
                'T', //37
                'T', //38
                'T', //39
                'T', //40
                'T', //41
                'T', //42
                'T', //43
                'H', //44
                'H', //45
                'H', //46
                'H', //47
                'H', //48
                'H', //49
                'H', //50
                'H', //51
                'H', //52
            ],
            [
                'T', //1
                'T', //2
                'T', //3
                'T', //4
                'T', //5
                'T', //6
                'T', //7
                'T', //8
                'T', //9
                'T', //10
                'T', //11
                'T', //12
                'T', //13
                'T', //14
                'T', //15
                'T', //16
                'S', //17
                'H', //18
                'H', //19
                'T', //20
                'T', //21
                'T', //22
                'T', //23
                'T', //24
                'T', //25
                'T', //26
                'T', //27
                'T', //28
                'T', //29
                'T', //30
                'T', //31
                'T', //32
                'T', //33
                'T', //34
                'T', //35
                'T', //36
                'S', //37
                'S', //38
                'P', //39
                'P', //40
                'P', //41
                'P', //42
                'P', //43
                'H', //44
                'H', //45
                'H', //46
                'H', //47
                'H', //48
                'H', //49
                'H', //50
                'H', //51
                'H', //52
            ],
            [
                'T', //1
                'T', //2
                'T', //3
                'T', //4
                'T', //5
                'T', //6
                'T', //7
                'T', //8
                'T', //9
                'T', //10
                'T', //11
                'T', //12
                'T', //13
                'T', //14
                'T', //15
                'T', //16
                'S', //17
                'H', //18
                'H', //19
                'T', //20
                'T', //21
                'T', //22
                'T', //23
                'T', //24
                'T', //25
                'T', //26
                'T', //27
                'T', //28
                'T', //29
                'T', //30
                'T', //31
                'T', //32
                'T', //33
                'T', //34
                'T', //35
                'T', //36
                'S', //37
                'S', //38
                'P', //39
                'P', //40
                'P', //41
                'P', //42
                'P', //43
                'H', //44
                'H', //45
                'H', //46
                'H', //47
                'H', //48
                'H', //49
                'H', //50
                'H', //51
                'H', //52
            ],
            [
                'T', //1
                'T', //2
                'T', //3
                'T', //4
                'T', //5
                'T', //6
                'T', //7
                'T', //8
                'T', //9
                'T', //10
                'T', //11
                'T', //12
                'T', //13
                'T', //14
                'T', //15
                'T', //16
                'S', //17
                'H', //18
                'H', //19
                'T', //20
                'T', //21
                'T', //22
                'T', //23
                'T', //24
                'T', //25
                'T', //26
                'T', //27
                'S', //28
                'P', //29
                'P', //30
                'P', //31
                'P', //32
                'P', //33
                'P', //34
                'P', //35
                'P', //36
                'P', //37
                'DP', //38
                'DP', //39
                'DP', //40
                'DP', //41
                'DP', //42
                'DA', //43
                ' ', //44
                ' ', //45
                ' ', //46
                ' ', //47
                ' ', //48
                ' ', //49
                ' ', //50
                ' ', //51
                ' ', //52
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