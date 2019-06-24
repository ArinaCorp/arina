<?php

namespace app\modules\plans\controllers;

use app\components\DepDropHelper;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\subject_block\SubjectBlock;
use app\modules\plans\models\StudentPlan;
use app\modules\plans\models\WorkPlan;
use app\modules\rbac\filters\AccessControl;
use app\modules\students\models\Group;
use app\modules\students\models\Student;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use kartik\depdrop\DepDrop;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessRule;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\helpers\Url;
use nullref\core\interfaces\IAdminController;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\DetailView;

class StudentPlanController extends Controller implements IAdminController
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
                        'actions' => ['index', 'create', 'update', 'view', 'export'],
                        'roles' => [User::ROLE_STUDENT],
                    ],
                    [
                        'allow' => true,
                        'actions' => [],
                        'roles' => [User::ROLE_HEAD_OF_DEP, User::ROLE_CYCLIC_COM],
                    ],
                ]
            ]
        ];
    }


    /**
     * @return string
     */
    public function actionIndex()
    {

        //TODO: add searchModel
        $dataProvider = new ActiveDataProvider([
            'query' => StudentPlan::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionCreate()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        if (UserHelper::isStudent($user)) {
            $student = $user->student;
            $model = new StudentPlan([
                'student_id' => $student->id,
                'work_plan_id' => $student->currentWorkPlan->id,
                'semester' => $student->currentSemester,
            ]);
            $formView = '_student-form';
        } else {
            $model = new StudentPlan();
            $formView = '_form';
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'formView' => $formView,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        $model = $this->findModel($id);

        if (UserHelper::isStudent($user)) {
            $formView = '_student-form';
        } else {
            $formView = '_form';
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'formView' => $formView,
        ]);

    }

    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * @param $id integer
     * @throws NotFoundHttpException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function actionExport($id)
    {
        $model = $this->findModel($id);
        $model->getDocument();
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionApprove($id)
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        $model = $this->findModel($id);
        $model->approved_by = $user->id;
        $model->save(false);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionDisapprove($id)
    {
        $model = $this->findModel($id);
        $model->approved_by = null;
        $model->save(false);

        return $this->render('view', ['model' => $model]);

    }

    /**
     * @param $id
     * @return StudentPlan|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = StudentPlan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('plans', 'The requested page does not exist'));
        }
    }

    /**
     * @see DepDrop Action
     * @return array
     */
    public function actionGetStudentWorkPlans()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = '';
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {

                $studentId = $parents[0];
                $student = Student::findOne($studentId);
                $workPlans = WorkPlan::getMap('title', 'id', ['speciality_qualification_id' => $student->specialityQualification->id], false);
                $out = DepDropHelper::convertMap($workPlans);

            }
        }
        return ['output' => $out, 'selected' => ''];
    }

    /**
     * @see DepDrop Action
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionGetStudentSubjectBlocks()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = '';
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {

                $studentId = $parents[0];
                $student = Student::findOne($studentId);

                $workPlanId = $parents[1];
                $workPlan = WorkPlan::findOne($workPlanId);

                $course = $student->currentGroup->getCourse($workPlan->study_year_id);
                $semester = $parents[2];

                $subjectBlocks = SubjectBlock::getMap('created', 'id', ['work_plan_id' => $workPlanId, 'course' => $course, 'semester' => $semester]);

                $out = DepDropHelper::convertMap($subjectBlocks);

            }
        }
        return ['output' => $out, 'selected' => ''];
    }

}