<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 30.04.2019
 * Time: 19:22
 */

namespace app\modules\journal\controllers;

use app\modules\directories\models\StudyYear;
use app\modules\journal\models\record\JournalMark;
use app\modules\journal\models\record\JournalRecord;
use app\modules\load\models\Load;
use app\modules\rbac\filters\AccessControl;
use app\modules\user\models\User;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class MarksAccountingController extends Controller implements IAdminController
{
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

    public function actionIndex($load_id = null)
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        $current_year = StudyYear::getCurrentYear();
        $loads = Load::find()
            ->joinWith('workSubject.subject')
            ->joinWith('group')
            ->where([
                'employee_id' => $user->employee_id,
                'study_year_id' => $current_year->id,
            ])->getMap('fullTitle');

        $marks = [];

        $load = Load::findOne($load_id);
        if (!$load) {
            $load = new Load();
        }

        $load->employee_id = $user->employee_id;

        $record = JournalRecord::create($load->id, $user->employee_id);

        if (Yii::$app->request->isPost) {
            //@TODO save with validation
            if ($record->load(Yii::$app->request->post()) && $record->save(false)) {
                $record = JournalRecord::create($load->id, $user->employee_id);
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
                        } else {
                            $marks[$student->id][$journalRecord->id] = new JournalMark();
                        }
                    }
                }
            }
        }

        return $this->render('index', [
            'loads' => $loads,
            'load' => $load,
            'record' => $record,
            'marks' => $marks
        ]);
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