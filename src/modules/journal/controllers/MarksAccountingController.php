<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 30.04.2019
 * Time: 19:22
 */

namespace app\modules\journal\controllers;

use app\modules\directories\models\StudyYear;
use app\modules\journal\models\accounting\MarksAccountingForm;
use app\modules\journal\models\record\JournalMark;
use app\modules\journal\models\record\JournalRecord;
use app\modules\load\models\Load;
use app\modules\rbac\filters\AccessControl;
use app\modules\user\helpers\UserHelper;
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

    public function actionIndex($load_id = null, $marks = null)
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        $current_year = StudyYear::getCurrentYear();
        $loads = Load::find()
            ->joinWith('workSubject.subject')
            ->joinWith('group')
            ->where([
//                    'employee_id' => $user->employee_id,
//                    'study_year_id' => $current_year->id,
                'employee_id' => 2,
                'study_year_id' => 6,
            ])->getMap('fullTitle');

        $marks = [];

        if ($load_id) {
            $load = Load::findOne($load_id);

            $marksRecords = JournalMark::find()
                ->joinWith('evaluation')
                ->where([
                    'record_id' => $load->getJournalRecords()->select('id')->column(),
                ])->all();

            $students = $load->group->getStudentsArray();

            $records = $load->journalRecords;

            foreach ($students as $student) {
                foreach ($records as $record) {
                    foreach ($marksRecords as $mark) {
                        if ($student->id == $mark->student_id && $record->id == $mark->record_id) {
                            $marks[$mark->student_id][$mark->record_id] = $mark->evaluation->value;
                        } else {
                            $marks[$student->id][$record->id] = null;
                        }
                    }
                }
            }
        }

        $record = new JournalRecord();

        if (Yii::$app->request->isPost){
            if ($record->load(Yii::$app->request->post())) {
                $record->load_id = $load->id;
                $record->teacher_id = $load->employee_id;
                $record->save(false);
            }

            if (Yii::$app->request->post('save')) {

            }
        }



        return $this->render('index', [
            'loads' => $loads,
            'load' => $load,
            'record' => $record,
            'marks' => $marks
        ]);
    }

    public function actionCreate($load_id)
    {
        $load = Load::findOne($load_id);

        $model = new JournalRecord([
            'load_id' => $load_id,
            'teacher_id' => $load->employee_id,
            'type' => 1
        ]);

        if ($model->save(false)) {
            return $this->redirect(['/site/index', 'load_id' => $load_id]);
        }
    }
}