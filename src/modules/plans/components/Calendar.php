<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2019 NRE
 */


namespace app\modules\plans\components;


use app\helpers\GlobalHelper;
use app\modules\directories\models\study_year\StudyYear;
use app\modules\plans\components\exceptions\Calendar as CalendarException;
use app\modules\plans\models\WorkPlan;
use yii\base\Component;
use yii\web\Session;

class Calendar extends Component
{
    const CALENDAR_YEAR_ID = 'calendar_year_id';
    const CALENDAR_WEEK_NUMBER = 'calendar_week_number';

    const STUDY_YEAR_MONTH_START = 9;

    protected $_session;

    public function __construct(Session $session, array $config = [])
    {
        $this->_session = $session;
        parent::__construct($config);
    }

    /**
     * @return StudyYear|array|\yii\db\ActiveRecord|null
     * @throws CalendarException
     */
    public function getCurrentYear()
    {
        $yearId = $this->_session->get(self::CALENDAR_YEAR_ID);

        if ($yearId == null) {
            $currentYear = date('Y');
            $currentMonth = $this->getCurrentMonth();

            //New year start from September
            if ($currentMonth >= self::STUDY_YEAR_MONTH_START) {
                $year = StudyYear::find()->where(['year_start' => $currentYear - 1])->one();
            } else {
                $year = StudyYear::find()->where(['year_start' => $currentYear])->one();
            }

            //If can't find year, try to find active
            if ($year == null) {
                $year = StudyYear::getActive();
            }

            //If can't find year, try to create it
            if ($year == null) {
                $year = $this->createCurrentStudyYear($currentYear);
            }

        } else {
            $year = StudyYear::findOne(['id' => $yearId]);
        }

        if ($year != null) {
            return $year;
        }

        throw CalendarException::cantGet();
    }

    /**
     * @return int
     */
    public function getCurrentMonth()
    {
        $week = $this->getCurrentWeek();

        $month = intval(date('m'));

        foreach (array_values(GlobalHelper::getWeeksByMonths()) as $m => $weeksByMonth) {
            $week -= $weeksByMonth;
            $month = $this->fixMonth($m + self::STUDY_YEAR_MONTH_START);
            if ($week <= 0) {
                break;
            }
        }

        return $month;
    }

    /**
     * @return float|int|mixed
     */
    public function getCurrentWeek()
    {
        $week = $this->_session->get(self::CALENDAR_WEEK_NUMBER);
        if ($week == null) {
            $week = $this->getWeekNumberByDate();
        }
        return $week;
    }

    /**
     * @return float|int
     */
    protected function getWeekNumberByDate()
    {
        $month = intval(date('m'));
        $week = 0;
        foreach (array_values(GlobalHelper::getWeeksByMonths()) as $m => $weeksByMonth) {
            if ($month == $this->fixMonth($m + self::STUDY_YEAR_MONTH_START)) {
                $d = intval(date('d'));
                $week += $d / 7;
                return ceil($week);
            }
            $week += $weeksByMonth;
        }
        return $week % 52;
    }

    /**
     *
     * @param $month
     * @return int
     */
    protected function fixMonth($month)
    {
        $month = $month % 12;
        if ($month == 0) {
            $month = 12;
        }
        return $month;
    }

    /**
     * @param $currentYear
     * @return StudyYear
     * @throws CalendarException
     */
    protected function createCurrentStudyYear($currentYear)
    {
        $model = new StudyYear();
        $model->year_start = $currentYear;
        if (!$model->save()) {
            throw CalendarException::cantCreate();
        }
        return $model;
    }

    /**
     * @param StudyYear $year
     */
    public function setCurrentYear(StudyYear $year)
    {
        $this->_session->set(self::CALENDAR_YEAR_ID, $year->id);
    }

    /**
     * @param $week
     */
    public function setCurrentWeek($week)
    {
        $this->_session->set(self::CALENDAR_WEEK_NUMBER, $week);
    }

    /**
     * @param WorkPlan $workPlan
     * @param int $course
     * @return int
     */
    public function getCurrentSemester(WorkPlan $workPlan, int $course)
    {
        $courseGraph = $workPlan->graph[$course - 1];
        $currentWeek = $this->getCurrentWeek();
        $findFirst = false;
        $findHoliday = false;
        $findSecond = false;
        foreach ($courseGraph as $week => $type) {
            if ($week >= $currentWeek) {
                break;
            }
            if ($type == ' ') {
                break;
            }
            if (($type != 'T') && ($type != 'P') && (!$findFirst)) {
                $findFirst = true;
            } elseif (($type == 'H') && ($findFirst) && !$findHoliday) {
                $findHoliday = true;
            } elseif (($type == 'T') && ($findFirst) && $findHoliday) {
                $findSecond = true;
            }
        }
        if ($findSecond) {
            return 2;
        }
        return 1;
    }


}