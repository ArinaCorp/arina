<?php

namespace app\modules\journal\controllers;

use app\components\DepDropHelper;
use app\components\exporters\marks\BaseMarkExporter;
use app\components\ExportToExcel;
use app\modules\journal\helpers\MarkHelper;
use app\modules\journal\models\record\JournalMark;
use app\modules\journal\models\record\JournalRecord;
use app\modules\load\models\Load;
use app\modules\plans\components\Calendar;
use app\modules\plans\models\WorkPlan;
use app\modules\rbac\filters\AccessControl;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\base\Module;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;

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
            /** @var Load[] $loads */
            $loads = Load::find()
                ->joinWith('workSubject.subject')
                ->joinWith('group')
                ->where([
                    'employee_id' => $user->employee_id,
                    'study_year_id' => $current_year->id,
                ])->all();

            //get loads that have hours in current semester
            $loads = array_filter($loads, function (Load $load) {
                $course = $load->group->getCourse();
                $graph = $load->getGraphRow($this->_calendar->getCurrentYear()->id);
                $semesterIndex = $this->_calendar->getSemesterIndexByCourse($course, $this->_calendar->getCurrentSemester($graph));
                return $load->workSubject->total[$semesterIndex];
            });

            $loads = ArrayHelper::map($loads, 'id', 'fullTitle');
        }

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

        $records = [];
        $marks = [];

        if ($load->id) {
            $records = $load->journalRecords;

            //get graph for load by group and workPlan
            $graph = $load->getGraphRow($this->_calendar->getCurrentYear()->id);
            $currentSemester = $this->_calendar->getCurrentSemester($graph);

            //get records that were added in current semester
            $records = array_filter($records, function (JournalRecord $record) use ($graph, $currentSemester) {
                $recordWeek = $this->_calendar->getWeekNumberByDate(strtotime($record->date));
                $recordSemester = $this->_calendar->getSemester($graph, $recordWeek);
                return $recordSemester === $currentSemester;
            });

            $marks = MarkHelper::getMarks($load->id, $records);
        }
        return $this->render('index', [
            'isTeacher' => $isTeacher,
            'loads' => $loads,
            'load' => $load,
            'record' => $record,
            'records' => $records,
            'marks' => $marks
        ]);
    }

    public function actionGetGroups()
    {
        if ($parents = Yii::$app->request->post('depdrop_parents')) {
            if ($parents) {
                $work_plan_id = $parents[0];
                $groups = WorkPlan::findOne(['id' => $work_plan_id])->getGroups();
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

    /**
     * @param $recordId
     * @throws NotFoundHttpException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     * @throws \yii\base\Exception
     */
    public function actionExport($recordId)
    {
        $record = JournalRecord::findOne($recordId);
        if ($record === null) {
            throw  new NotFoundHttpException();
        }
        BaseMarkExporter::exportRecord($record);
    }

    public function actionRetakeForm()
    {
        $model = new JournalRecord();
        $model->load(Yii::$app->request->post());

        $retakeItems = [];

        if ($load = $model->load) {

            $records = $load->journalRecords;

            //get graph for load by group and workPlan
            $graph = $load->getGraphRow($this->_calendar->getCurrentYear()->id);
            $currentSemester = $this->_calendar->getCurrentSemester($graph);

            //get records that were added in current semester
            $records = array_filter($records, function (JournalRecord $record) use ($model, $graph, $currentSemester) {
                $recordWeek = $this->_calendar->getWeekNumberByDate(strtotime($record->date));
                $recordSemester = $this->_calendar->getSemester($graph, $recordWeek);
                return $recordSemester === $currentSemester && $record->type == $model->type && !$record->retake_for_id;
            });
            $retakeItems = ArrayHelper::map($records, 'id', function ($record) {
                return ($record->typeObj ? $record->typeObj->title : '') . ' ' . $record->date;
            });
        }


        return $this->renderPartial('_retake', [
            'record' => $model,
            'form' => new ActiveForm(),
            'retakeItems' => $retakeItems,
        ]);
    }
}