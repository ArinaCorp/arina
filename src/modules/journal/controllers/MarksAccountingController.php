<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 30.04.2019
 * Time: 19:22
 */

namespace app\modules\journal\controllers;

use app\components\DepDropHelper;
use app\modules\directories\models\study_year\StudyYear;
use app\modules\journal\models\record\JournalMark;
use app\modules\journal\models\record\JournalRecord;
use app\modules\load\models\Load;
use app\modules\plans\models\WorkPlan;
use app\modules\plans\components\Calendar;
use app\modules\rbac\filters\AccessControl;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class MarksAccountingController extends Controller implements IAdminController
{
    /** @var Calendar */
    protected $_calendar;

    /**
     * MarksAccountingController constructor.
     * @param string $id
     * @param Module $module
     * @param Calendar $calendar
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
            'verbs' => [
                'class' => VerbFilter::class,
            ],
            'access' => [

                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [],
                        'roles' => ['teacher'],
                    ]
                ]
            ]
        ];
    }

    /**
     * @param null $load_id
     * @return string
     * @throws \app\modules\plans\components\exceptions\Calendar
     */
    public function actionIndex($load_id = null)
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        $loads = [];

        $isTeacher = UserHelper::hasRole($user, 'teacher');
        if ($isTeacher) {
            $current_year = $this->_calendar->getCurrentYear();
            $loads = Load::find()
                ->joinWith('workSubject.subject')
                ->joinWith('group')
                ->where([
                    'employee_id' => $user->employee_id,
                    'study_year_id' => $current_year->id,
                ])->getMap('fullTitle');
        }

        $marks = [];

        $load = Load::findOne($load_id);
        if (!$load) {
            $load = new Load();
        }

        $load->employee_id = $user->employee_id;

        $record = JournalRecord::create($load->id, $user->id);

        if (Yii::$app->request->isPost) {
            //@TODO save with validation
            if ($record->load(Yii::$app->request->post()) && $record->save(false)) {
                $record = JournalRecord::create($load->id, $user->id);
            }
        }

        if ($load->id) {
            $marksRecords = JournalMark::find()
                ->joinWith('evaluation')
                ->where([
                    'record_id' => $load->getJournalRecords()->select('id')->column(),
                ])->all();

            $students = $load->group->getStudentsArray();

            $records = $load->journalRecords;

            foreach ($students as $student) {
                foreach ($records as $journalRecord) {
                    foreach ($marksRecords as $mark) {
                        if ($student->id == $mark->student_id && $journalRecord->id == $mark->record_id) {
                            $marks[$mark->student_id][$mark->record_id] = $mark;
                        }
                    }
                    if (!isset($marks[$student->id][$journalRecord->id])) {
                        $marks[$student->id][$journalRecord->id] = new JournalMark();
                    }
                }
            }
        }
        return $this->render('index', [
            'isTeacher' => $isTeacher,
            'loads' => $loads,
            'load' => $load,
            'record' => $record,
            'marks' => $marks
        ]);
    }

    public function actionGetGroups()
    {
        if ($parents = Yii::$app->request->post('depdrop_parents')) {
            if ($parents) {
                $work_plan_id = $parents[0];
                $groups = WorkPlan::findOne(['id' => $work_plan_id])->specialityQualification->groups;
                $out = DepDropHelper::convertMap(ArrayHelper::map($groups, 'id', 'title'));
                return $this->asJson(['output' => $out, 'selected' => Yii::t('app', 'Select group')]);
            }
        }
        return $this->asJson(['output' => '', 'selected' => '']);
    }

    public function actionGetLoads()
    {
        if ($parents = Yii::$app->request->post('depdrop_parents')) {
            if ($parents) {
                $work_plan_id = empty($parents[0]) ? null : $parents[0];
                $group_id = empty($parents[1]) ? null : $parents[1];
                if ($work_plan_id && $group_id) {
                    $items = Load::find()->byWorkPlanForGroup($work_plan_id, $group_id)->getMap('workSubject.title');
                    $out = DepDropHelper::convertMap($items);
                    return $this->asJson(['output' => $out, 'selected' => Yii::t('app', 'Select load')]);
                }
            }
        }
        return $this->asJson(['output' => '', 'selected' => '']);
    }

    public function actionCreateMark()
    {
        $model = new JournalMark();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->asJson([
                    'message' => Yii::t('app', 'Created'),
                    'data' => $model
                ]);
            }
        }
    }

    public function actionUpdateMark($id)
    {
        $model = JournalMark::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->asJson([
                    'message' => Yii::t('app', 'Updated'),
                    'data' => $model
                ]);
            }
        }
    }

    public function actionDeleteMark($id)
    {
        $model = JournalMark::findOne($id);
        if ($model) {
            if ($model->delete()) {
                return $this->asJson([
                    'message' => Yii::t('app', 'Deleted'),
                    'data' => null,
                ]);
            }
        }
    }
}