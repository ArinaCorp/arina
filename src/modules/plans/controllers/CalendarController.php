<?php

namespace app\modules\plans\controllers;

use app\modules\directories\models\study_year\StudyYear;
use app\modules\plans\components\Calendar;
use app\modules\plans\models\WorkPlan;
use app\modules\rbac\filters\AccessControl;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\base\Module;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class CalendarController extends Controller implements IAdminController
{
    /** @var Calendar */
    protected $_calendar;

    /**
     * SiteController constructor.
     * @param Calendar $calendar
     * @param string $id
     * @param Module $module
     * @param array $config
     */
    public function __construct(string $id, Module $module, Calendar $calendar, array $config = [])
    {
        $this->_calendar = $calendar;
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [],
                        'roles' => ['teacher'],
                    ]
                ]
            ],
        ];
    }

    /**
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionSetCurrentYear()
    {
        $id = Yii::$app->request->post('id');
        if ($id) {
            $studyYear = StudyYear::findOne(['id' => $id]);
            if ($studyYear != null) {
                $this->_calendar->setCurrentYear($studyYear);
                if (Yii::$app->request->isAjax) {
                    return $this->asJson([
                        'success' => true,
                        'message' => Yii::t('app', 'Study year has been changed'),
                    ]);
                }
                return $this->redirect(Yii::$app->request->referrer ?? Yii::$app->homeUrl);
            }
        }
        throw new BadRequestHttpException();
    }

    /**
     * @return \yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionSetCurrentWeek()
    {
        $week = Yii::$app->request->post('week');
        if ($week) {
            $this->_calendar->setCurrentWeek($week);
            if (Yii::$app->request->isAjax) {
                return $this->asJson([
                    'success' => true,
                    'message' => Yii::t('app', 'Study week has been changed'),
                ]);
            }
            return $this->redirect(Yii::$app->request->referrer ?? Yii::$app->homeUrl);
        }
        throw new BadRequestHttpException();
    }

    /**
     * @param int $work_plan_id
     * @param int $course
     * @return string
     */
    public function actionInfo($work_plan_id, $group=null)
    {
        $workPlan = WorkPlan::findOne(['id' => $work_plan_id]);
        if ($group) {
            $rows = $workPlan->specialityQualification->getGroupsByStudyYear($workPlan->study_year_id);
            $graphIndex = array_search($group, array_keys($rows));
            $semester = $this->_calendar->getCurrentSemester($workPlan->graph[$graphIndex]);
        }

        $course = 1;
        return $this->render('info', [
            'workPlan' => $workPlan,
            'course' => $course,
            'semester' => $semester,
            'week' => $this->_calendar->getCurrentWeek(),
            'group' => $group
        ]);
    }
}