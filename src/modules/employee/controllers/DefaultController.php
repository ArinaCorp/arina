<?php

namespace app\modules\employee\controllers;

use app\modules\employee\models\EmployeeEducation;
use app\modules\employee\models\EmployeeSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\base\Model;
use yii\base\Exception;
use app\modules\employee\models\Employee;
use yii\web\NotFoundHttpException;
use nullref\core\interfaces\IAdminController;
use Yii;

/**
 * Default controller for the `employee` module
 */
class DefaultController extends Controller implements IAdminController
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
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Employee model.
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
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Employee();
        $modelsEducation = [new EmployeeEducation()];

        /**
         * @var $modelsEducation EmployeeEducation[]
         */

        if ($model->load(Yii::$app->request->post())) {
            $modelsEducation = Employee::createMultiple(EmployeeEducation::className());
            Model::loadMultiple($modelsEducation, Yii::$app->request->post());
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsEducation) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsEducation as $modelEducation) {
                            $modelEducation->employee_id = $model->id;
                            if (!($flag = $modelEducation->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'modelsEducation' => (empty($modelsEducation)) ? [new EmployeeEducation()] : $modelsEducation,
        ]);
    }

    /**
     * Updates an existing Employee model.
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
     * Deletes an existing Employee model.
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
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null)
            return $model;
        else
            throw new NotFoundHttpException('The requested page does not exist.');
    }

}
