<?php

namespace app\modules\employee\controllers;

use nullref\core\interfaces\IAdminController;
use Yii;
use app\modules\employee\models\cyclic_commission\CyclicCommission;
use app\modules\employee\models\cyclic_commission\CyclicCommissionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

/**
 * CyclicCommissionController implements the CRUD actions for CyclicCommission model.
 */
class CyclicCommissionController extends Controller implements IAdminController
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
        ];
    }

    /**
     * Lists all CyclicCommission models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CyclicCommissionSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => CyclicCommission::find(),
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CyclicCommission model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $dataProvider = new ArrayDataProvider([
            'allModels' => $this->findModel($id)->getEmployeeArray(),
        ]);
        
        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CyclicCommission model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CyclicCommission();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CyclicCommission model.
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
     * Deletes an existing CyclicCommission model.
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
     * Finds the CyclicCommission model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CyclicCommission the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CyclicCommission::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
