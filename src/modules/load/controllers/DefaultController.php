<?php

namespace app\modules\load\controllers;

use app\components\DepDropHelper;
use app\modules\directories\models\study_year\StudyYear;
use app\modules\directories\models\study_year\StudyYearSearch;
use app\modules\employee\models\CyclicCommission;
use app\modules\load\models\Load;
use app\modules\load\models\LoadSearch;
use app\modules\plans\models\WorkSubject;
use app\modules\rbac\filters\AccessControl;
use app\modules\students\models\Group;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

//@TODO refactor to yii2
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

    /**
     * @return string
     */
    public function actionIndex()
    {
        $studyYearIds = Load::find()->select('study_year_id')->groupBy('study_year_id')->column();
        $searchModel = new StudyYearSearch();
        $dataProvider = $searchModel->search(
            Yii::$app->request->queryParams,
            StudyYear::find()->andWhere(['id' => $studyYearIds])
        );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionCreate()
    {
        if (isset($_POST['study_year'])) {

            $this->generateLoadFor($_POST['study_year']);
            return $this->redirect(Url::to('index'));
        }

        return $this->render('create');
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
        Load::deleteAll(['study_year_id' => $studyYear]);
        foreach ($year->workPlans as $plan) {
            $groups = $plan->getGroups();
            foreach ($plan->workSubjects as $subject) {
                /** @var Group $group */
                foreach ($groups as $group) {
                    $course = $group->getCourse($year->id);
                    $spring = $course * 2;
                    $fall = $spring - 1;
                    if (!empty($subject->total[$fall - 1]) || !empty($subject->total[$spring - 1])) {
                        $this->getNewLoad($year, $subject, $group, $course, Load::TYPE_LECTURES);

                        if ($subject->dual_practice && (!empty($subject->practices[$fall - 1]) || !empty($subject->practices[$spring - 1]))) {
                            $this->getNewLoad($year, $subject, $group, $course, Load::TYPE_PRACTICES);
                        }

                        if ($subject->dual_lab_work && (!empty($subject->lab_works[$fall - 1]) || !empty($subject->lab_works[$spring - 1]))) {
                            $this->getNewLoad($year, $subject, $group, $course, Load::TYPE_LAB_WORKS);
                        }

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
        $model->save();
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = Load::findOne($id);
        $year = $model->study_year_id;
        $model->delete();
        return $this->redirect(Url::to('view', ['id' => $year]));
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->study_year_id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * @param $id
     * @return Load|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Load::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id StudyYear Id
     * @return string
     */
    public function actionView($id)
    {
        $model = new LoadSearch([
            'study_year_id' => $id
        ]);

        //set filtering by current teacher
        /** @var User $user */
        $user = Yii::$app->user->identity;
        if(UserHelper::isTeacher($user)){
            $model->commission_id = $user->employee->cyclic_commission_id;
            $model->employee_id = $user->employee_id;
        }

        $dataProvider = $model->search(Yii::$app->request->queryParams);
        $year = StudyYear::findOne($id);
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'year' => $year]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionGenerate($id)
    {
        $this->generateLoadFor($id);
        return $this->redirect(Url::to('view', ['id' => $id]));
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionProject($id)
    {
        $model = new Load(['scenario' => 'project']);
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

    /**
     * @param $id
     * @return string|\yii\web\Response
     *
     * @TODO remove if doesn't use
     */
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

    /**
     * @param $id
     * @return string
     *
     * @TODO remove if doesn't use
     */
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
        return $this->render('doc', ['model' => $model, 'year' => $year]);
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