<?php

namespace app\modules\employee\controllers;

use app\modules\employee\models\Employee;
use app\modules\employee\models\EmployeeSearch;
use app\modules\rbac\filters\AccessControl;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
                        'roles' => ['staff-office'],
                    ]
                ]
            ]
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
     * @param $id
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
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Employee();

        $default = Yii::$app->request->isPost ? [
            'EmployeeEducation' => [],
        ] : [];
        if ($model->loadWithRelations(array_merge($default, Yii::$app->request->post()))
            && $model->validateWithRelations()
            && $model->save(false)) {
            if (!Yii::$app->request->post('stay')) {
                return $this->redirect(['/employee/default']);
            } else {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Employee record is saved!'));
                return $this->redirect(['/employee/default/update', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'activeTab' => (int)Yii::$app->request->post('activeTab', 0),
        ]);
    }


    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $default = Yii::$app->request->isPost ? [
            'EmployeeEducation' => [],
        ] : [];
        if ($model->loadWithRelations(array_merge($default, Yii::$app->request->post()))
            && $model->validateWithRelations()
            && $model->save(false)) {
            if (!Yii::$app->request->post('stay')) {
                return $this->redirect(['/employee/default']);
            } else {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Employee record is saved!'));
            }
        }

        return $this->render('update', [
            'model' => $model,
            'activeTab' => (int)Yii::$app->request->post('activeTab', 0),
        ]);
    }

    /**
     * Deletes an existing Employee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
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

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function actionDocument()
    {
        return Employee::getDocument();
    }

}
