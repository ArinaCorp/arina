<?php

namespace app\modules\students\controllers;

use app\components\DepDropHelper;
use app\modules\students\models\StudentsHistory;
use Yii;
use app\modules\students\models\ExemptionStudentRelation;
use app\modules\students\models\ExemptionStudentRelationSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use nullref\core\interfaces\IAdminController;
use yii\web\Response;

/**
 * ExemptionStudentRelationsController implements the CRUD actions for ExemptionStudentRelation model.
 */
class ExemptionStudentRelationsController extends Controller implements IAdminController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ExemptionStudentRelation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExemptionStudentRelationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ExemptionStudentRelation model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ExemptionStudentRelation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ExemptionStudentRelation();
        $model->date_start = date('Y-m-d');
        $model->date_end = date('Y-m-d');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ExemptionStudentRelation model.
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
     * Deletes an existing ExemptionStudentRelation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ExemptionStudentRelation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExemptionStudentRelation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExemptionStudentRelation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public
    function actionGetStudentsList()
    {
        $out = [];
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $group_id = $params['group_id'];
                    $out = DepDropHelper::convertMap(StudentsHistory::getActiveStudentByGroupList($group_id));
                    return ['output' => $out, 'selected' => ''];
                }
            }
            return ['output' => '', 'selected' => ''];
        }
    }
}
