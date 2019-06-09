<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2019 NRE
 */


namespace app\modules\plans\widgets;


use app\helpers\GlobalHelper;
use app\modules\directories\models\study_year\StudyYear;
use app\modules\plans\components\Calendar;
use yii\base\Widget;

class CalendarWidget extends Widget
{
    protected $_calendar;

    public function __construct(Calendar $calendar, array $config = [])
    {
        $this->_calendar = $calendar;
        parent::__construct($config);
    }

    /**
     * @return string
     * @throws \app\modules\plans\components\exceptions\Calendar
     */
    public function run()
    {
        $years = StudyYear::getMap('title', 'id', null, false);

        $yearId = null;
        $year = $this->_calendar->getCurrentYear();

        $week = $this->_calendar->getCurrentWeek();

        $weeks = [];

        $counter = 1;
        foreach (GlobalHelper::getWeeksByMonths() as $month => $weeksByMonth) {
            $weeks[\Yii::t('app', $month)] = [];
            for ($i = 0; $i < $weeksByMonth; $i++) {
                $weeks[\Yii::t('app', $month)][$counter] = $counter;
                $counter++;
            }
        }

        return $this->render('calendar', [
            'years' => $years,
            'year' => $year,
            'weeks' => $weeks,
            'week' => $week,
        ]);
    }
}