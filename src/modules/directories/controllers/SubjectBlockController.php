<?php

namespace app\modules\directories\controllers;

use app\components\DepDropHelper;
use app\modules\directories\models\subject\Subject;
use app\modules\directories\models\subject_block\SubjectBlock;
use app\modules\directories\models\subject_block\SubjectBlockSearch;
use app\modules\plans\models\WorkPlan;
use app\modules\plans\models\WorkSubject;
use app\modules\rbac\filters\AccessControl;
use app\modules\user\models\User;
use Yii;
use yii\bootstrap\Alert;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use nullref\core\interfaces\IAdminController;
use yii\web\Response;
use yii\widgets\DetailView;

/**
 * SubjectBlockController implements the CRUD actions for SubjectBlock model.
 */
class SubjectBlockController extends Controller implements IAdminController
{

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
                        'actions' => ['subject-preview'],
                        'roles' => [User::ROLE_STUDENT],
                    ],
                ]
            ]
        ];
    }

    /**
     * Lists all SubjectBlock models.
     * @return mixed
     */

    public function actionIndex()
    {
        $searchModel = new SubjectBlockSearch();
        $dataProvider = new ActiveDataProvider(['query' => SubjectBlock::find()]);
        // TODO: No search model implemented for SubjectBlock
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SubjectBlock model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new SubjectBlock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SubjectBlock();

        if ($model->load(Yii::$app->request->post()) && $model->save() && $model->saveSelectedSubjects()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing SubjectBlock model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->selectedSubjects = $model->workSubjects;

        if ($model->load(Yii::$app->request->post())
            && $model->save() && $model->saveSelectedSubjects(true)) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SubjectBlock model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
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
     * Finds the SubjectBlock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SubjectBlock|null the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SubjectBlock::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionGetOptionalSubjects()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = '';
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {

                $workPlanId = $parents[0];
                $course = $parents[1];
                $semester = $parents[2];

                // TODO: add the '+1' option for this method
                $fullSemester = Yii::$app->get('calendar')->getSemesterIndexByCourse($course, $semester) + 1;
                $workPlan = WorkPlan::findOne($workPlanId);
                $map = ArrayHelper::map($workPlan->getOptionalWorkSubjects($fullSemester), 'id', 'title');
                $out = DepDropHelper::convertMap($map);
            }
        }
        return ['output' => $out, 'selected' => ''];
    }

    /**
     * Returns the preview of subjects.
     * @param $id
     * @return string
     * @throws \Exception
     */
    public function actionSubjectPreview($id)
    {
        $model = $this->findModel($id);
        return DetailView::widget([
            'model' => $model,
            'attributes' => $model->getSubjectsDetail(),
        ]);
    }

}
