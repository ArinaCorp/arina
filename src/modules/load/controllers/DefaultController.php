<?php

namespace app\modules\load\controllers;

use app\components\DepDropHelper;
use app\modules\directories\models\cyclic_commission\CyclicCommission;
use app\modules\directories\models\StudyYear;
use app\modules\directories\models\StudyYearSearch;
use app\modules\load\models\Load;
use app\modules\load\models\LoadSearch;
use app\modules\plans\models\WorkSubject;
use app\modules\rbac\filters\AccessControl;
use app\modules\students\models\Group;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Console;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;

class DefaultController extends Controller implements IAdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [],
                        'roles' => ['head-of-department', 'head-of-cyclic-commission'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['teacher'],
                    ]
                ]
            ]
        ];
    }
    public function actionIndex()
    {
        $searchModel = new StudyYearSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => StudyYear::find()
        ]);
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        if (isset($_POST['study_year'])) {
            echo (($_POST['study_year']));
            $this->generateLoadFor($_POST['study_year']);
            return $this->redirect(Url::to('index'));
        }

        return $this->render('create');
    }

    public function actionDelete($id)
    {
        $model = Load::findOne($id);
        $year = $model->study_year_id;
        $model->delete();
        return $this->redirect(Url::to('view', ['id' => $year]));
    }

    /**
     * @param $studyYear
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    protected function generateLoadFor($studyYear)
    {
        /**
         * @var StudyYear $year
         * @var Load $load
         */
        $year = StudyYear::findOne($studyYear);
        $load = Load::find()->where(['study_year_id' => $studyYear])->one();
        if ($load) {
            $load->delete();
        }
        // TODO: remove debugs
//        var_dump($year->workPlans);
//        die;
        foreach ($year->workPlans as $plan) {
            $groups = $plan->specialityQualification->getGroupsByStudyYear($year->id);
//            var_dump($year->id);
            var_dump($groups);
//            die;
            foreach ($plan->workSubjects as $subject) {
                foreach ($groups as $title => $course) {
                    $spring = $course * 2;
                    $fall = $spring - 1;
                    $group = Group::findOne(['title' => $title]);
                    // TODO: remove debugs
//                    var_dump($title);
//                    var_dump($group);
//                    die;
//                    var_dump($subject->total[$fall-1]);
//                    var_dump($subject->total[$spring-1]);
//                    die;
                    if (!empty($subject->total[$fall-1]) || !empty($subject->total[$spring-1])) {
                        $this->getNewLoad($year, $subject, $group, $course, Load::TYPE_LECTURES);

                        if ($subject->dual_practice && (!empty($subject->practices[$fall-1]) || !empty($subject->practices[$spring-1]))) {
                            // TODO: remove 'die
                            echo 'FUCK YOU NIGGER';
                            $this->getNewLoad($year, $subject, $group, $course, Load::TYPE_PRACTICES); die;
                        }

                        if ($subject->dual_lab_work && (!empty($subject->lab_works[$fall-1]) || !empty($subject->lab_works[$spring-1]))) {
                            // TODO: remove 'die
                            echo 'FUCK YOUR MOM';
                            $this->getNewLoad($year, $subject, $group, $course, Load::TYPE_LAB_WORKS); die;
                        }
                        // TODO: remove 'die
//                        echo 'BURN IN THE STOVE FUCKING MUSLIM AND JEW';
//                        die;
                    }
                }
            }
        }
    }

    /**
     * @param StudyYear $studyYear
     * @param WorkSubject $subject
     * @param Group $group
     * @param int $course
     * @param int $type
     */
    protected function getNewLoad($studyYear, $subject, $group, $course, $type)
    {
        $model = new Load();
        $model->study_year_id = $studyYear->id;
        $model->work_subject_id = $subject->id;
//        var_dump($group); die;
        $model->group_id = $group->id;
        $model->type = $type;
        $model->course = $course;
        $consult = array();
        $consult[0] = $model->calcConsultation($course * 2 - 1);
        $consult[1] = $model->calcConsultation($course * 2);
        $model->consult = $consult;
        $students = array();
        $students[0] = count($group->getStudentsArray());
        $students[1] = $group->getCountByPayment(1);
        $students[2] = $group->getCountByPayment(2);
        $model->students = $students;
//        var_dump($model); die;
        $model->save();
    }

    public function actionUpdate($id)
    {
        /**
         * @var Load $model
         */
        $model = Load::findOne($id);

        if (isset($_POST['Load'])) {
            $model->setAttributes($_POST['Load'], false);
            if ($model->save()) {
                return $this->redirect(Url::to('view', ['id' => $model->study_year_id]));
            }
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionView($id)
    {
        $model = new LoadSearch();


        $dataProvider = $model->search(Yii::$app->request->queryParams);
        $year = StudyYear::findOne($id);
        return $this->render('view', ['model' => $model, 'dataProvider' => $dataProvider, 'year' => $year]);
    }

    public function actionGenerate($id)
    {
        $this->generateLoadFor($id);
        return $this->redirect(Url::to('view', ['id' => $id]));
    }

    public function actionProject($id)
    {
        $model = new Load('project');
        $model->study_year_id = $id;
        $model->type = Load::TYPE_PROJECT;

        if (isset($_POST['Load'])) {
            $model->setAttributes($_POST['Load'], false);
            $model->course = $model->group->getCourse($model->study_year_id);
            if ($model->save()) {
                return $this->redirect(Url::to('view', ['id' => $id]));
            }
        }

        return $this->render('project', array('model' => $model));
    }

    public function actionEdit($id)
    {
        /** @var Load $model */
        $model = Load::findOne($id);
        $model->setScenario('project');
        $model->commissionId = $model->employee->cyclic_commission_id;

        if (isset($_POST['Load'])) {
            $model->setAttributes($_POST['Load'], false);
            $model->course = $model->group->getCourse($model->study_year_id);
            if ($model->save()) {
                return $this->redirect(Url::to('view', ['id' => $model->study_year_id]));
            }
        }

        return $this->render('project', ['model' => $model]);
    }

    public function actionDoc($id)
    {
        /** @var StudyYear $year */
        $year = StudyYear::model()->loadContent($id);
        $model = new LoadDocGenerateModel();
        if (isset($_POST['LoadDocGenerateModel'])) {
            $model->setAttributes($_POST['LoadDocGenerateModel'], false);
            $model->yearId = $id;
            if ($model->validate()) {
                $model->generate();
            }
        }
        return $this->render('doc', ['model' => $model, 'year'=>$year]);
    }

    /**
     * @return string
     */
    public function actionGetEmployees()
    {
        if ($parents = Yii::$app->request->post('depdrop_parents')) {

            if (Yii::$app->request->post('depdrop_all_params')) {
                $commissionId = $parents[0]; // get the value of input-type-1
                if ($commissionId) {
                    $out = DepDropHelper::convertMap(CyclicCommission::getEmployeeByCyclicCommissionMap($commissionId));
                    return Json::encode(['output' => $out, 'selected' => Yii::t('app', 'Select teacher')]);
                }
            }
            return Json::encode(['output' => [], 'selected' => Yii::t('app', 'Select ...')]);
        }
    }
}