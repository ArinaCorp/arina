<?php

namespace app\modules\plans\controllers;

use app\components\DepDropHelper;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\subject_block\SubjectBlock;
use app\modules\plans\models\StudentPlan;
use app\modules\rbac\filters\AccessControl;
use app\modules\students\models\Group;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use kartik\depdrop\DepDrop;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\helpers\Url;
use nullref\core\interfaces\IAdminController;
use yii\web\NotFoundHttpException;
use yii\web\Response;

use app\modules\plans\models\WorkPlan;
use app\modules\plans\models\WorkSubject;
use app\modules\plans\models\WorkPlanSearch;

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
                        'actions' => [],
                        'roles' => ['head-of-department', 'head-of-cyclic-commission'],
                    ]
                ]
            ]
        ];
    }

    public $name = 'Student plan';

    /**
     * @return string
     */
    public function actionIndex()
    {
//        $searchModel = new StudentPlanSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//        $query = WorkPlan::find();
//
//        if (!Yii::$app->user->isGuest) {
//            /** @var User $user */
//            $user = Yii::$app->user->identity;
//
//            if (UserHelper::hasRole($user, 'head-of-department')) {
//                if ($user->employee && $user->employee->department) {
//                    $spQIds = SpecialityQualification::find()
//                        ->andWhere([
//                            'speciality_id' => $user->employee->department->getSpecialities()
//                                ->select('id')
//                                ->column(),
//                        ])
//                        ->select('id')
//                        ->column();
//                    $query->andWhere(['speciality_qualification_id' => $spQIds]);
//                }
//            }
//        }

        $dataProvider = new ActiveDataProvider([
            'query' => StudentPlan::find(),
        ]);

        return $this->render('index', [
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new StudentPlan();

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->loadsSubjectBlock() && !$model->loadsSubBlockSelect()) {
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }
        return $this->render('create', ['model' => $model]);
    }

    public function actionGetSubjectBlockList()
    {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $student_id = $params['student-id']; // get the value of input-type-1
                    $out = DepDropHelper::convertMap(SubjectBlock::getSubjectBlocksForStudent($student_id));
                    echo Json::encode(['output' => $out, 'selected' => Yii::t('app', 'Select ...')]);
                    return;
                }
            }
            echo Json::encode(['output' => [], 'selected' => Yii::t('app', 'Select ...')]);
            return;
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (!$model->loadsSubjectBlock() && !$model->loadsSubBlockSelect()) {
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }
        return $this->render('update', ['model' => $model]);

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

}