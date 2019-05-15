<?php

namespace app\modules\students\controllers;

use app\components\DepDropHelper;
use app\components\ExportToExcel;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\subject\Subject;
use app\modules\plans\models\StudyPlan;
use app\modules\rbac\filters\AccessControl;
use app\modules\students\models\Exemption;
use app\modules\students\models\ExportParams;
use app\modules\students\models\Group;
use app\modules\students\models\StudentFilter;
use app\modules\students\models\StudentSearch;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class GroupController extends Controller implements IAdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
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
                        'roles' => ['head-of-department'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'document'],
                        'roles' => ['teacher', 'curator'],
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $ids = [];

        $showAll = true;

        if (!Yii::$app->user->isGuest) {
            /** @var User $user */
            $user = Yii::$app->user->identity;

            if (UserHelper::hasRole($user, 'head-of-department')) {
                if ($user->employee && $user->employee->department) {
                    $spQIds = SpecialityQualification::find()
                        ->andWhere([
                            'speciality_id' => $user->employee->department->getSpecialities()
                                ->select('id')
                                ->column(),
                        ])
                        ->select('id')
                        ->column();

                    $showAll = false;
                    $ids = array_merge($ids, Group::find()->andWhere(['speciality_qualifications_id' => $spQIds])->select('id')->column());
                }
            }

            if (UserHelper::hasRole($user, 'curator')) {
                if ($user->employee) {
                    $curatorGroupId = Group::find()->andWhere(['curator_id' => $user->employee->id])->select('id')->column();
                    $ids = array_merge($ids, $curatorGroupId);
                    $showAll = false;
                }
            }
        }


        $query = Group::find();

        if (!$showAll) {
            $ids = array_unique($ids);
            $query->andWhere(['id' => $ids]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Group model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $exportParams = new ExportParams();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->findModel($id)->getStudentsArray(),
        ]);
        $dataProvider->pagination->setPageSize(40);


        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
            'exportParams' => $exportParams
        ]);
    }

    /**
     * Creates a new Group model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Group();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Group model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Group model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionDocument($id)
    {
        $model = $this->findModel($id);
        $model->getDocument();
    }

//    public function actionAttestation($id)
//    {
//        $model = [
//            'idGroup' => $id,
//        ];
//        ExportToExcel::getDocument('Attestation', $model);
//    }
    public function actionAttestation()
    {
        $data = (Yii::$app->request->post()["ExportParams"]);
        $model = [
            'data' => $data
        ];
        ExportToExcel::getDocument('Attestation', $model);
    }
    public function actionZalik()
    {
        $data = (Yii::$app->request->post()["ExportParams"]);
        $model = [
            'data' => $data
        ];
        ExportToExcel::getDocument('Zalik', $model);
    }
    public function actionSemester()
    {
        $data = (Yii::$app->request->post()["ExportParams"]);
        $model = [
            'data' => $data
        ];
        ExportToExcel::getDocument('Semester', $model);
    }
    public function actionExam()
    {
        $data = (Yii::$app->request->post()["ExportParams"]);
        $model = [
            'data' => $data
        ];
        ExportToExcel::getDocument('Exam', $model);
    }

    public static function actionSubjectList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $dep_id = null;
                    if($params["plan_id"]){
                        $dep_id = $params["plan_id"];
                    }
                    if($params["exam_plan_id"]){
                        $dep_id = $params["exam_plan_id"];
                    }
                    $plan = StudyPlan::findOne(['id'=>$dep_id]);
                    $subject_list = ArrayHelper::map($plan->studySubjects, 'id', 'title');
                    $out = DepDropHelper::convertMap($subject_list);
                    if (empty($dep_id)) {
                        $out = '';
                    }
                    return ['output' => $out, 'selected' => ''];
                }
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    /**
     * Finds the Group model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
