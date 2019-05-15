<?php

namespace app\modules\rbac\controllers;

use app\modules\rbac\models\ActionAccess;
use app\modules\rbac\models\ActionReader;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AccessController implements the CRUD actions for ControllerAccess model.
 */
class AccessController extends Controller implements IAdminController
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
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAddItems($id)
    {
        $actionAccess = $this->findModel($id);
        return $this->render('add-items', [
            'id' => $id,
            'actionAccess' => $actionAccess,
        ]);
    }

    /**
     * Finds the ControllerAccess model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ActionAccess the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ActionAccess::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionControllers()
    {
        $reader = new ActionReader();
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $module = $parents[0];
                $out = $reader->getControllersJs($module);
                return Json::encode(['output' => $out, 'selected' => 0]);
            }
        }
        return Json::encode(['output' => '', 'selected' => '']);
    }

    public function actionActions()
    {
        $reader = new ActionReader();
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $module = $parents[0];
                $controller = $parents[1];
                $out = $reader->getActionsJs($module, $controller);
                return Json::encode(['output' => $out, 'selected' => 0]);
            }
        }
        return Json::encode(['output' => '', 'selected' => '']);
    }

    /**
     * Lists all ControllerAccess models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ActionAccess::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ControllerAccess model.
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
     * Creates a new ControllerAccess model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ActionAccess();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ActionAccess model.
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
     * Deletes an existing ControllerAccess model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}
