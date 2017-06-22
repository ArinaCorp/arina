<?php

namespace app\modules\journal\controllers;

use app\components\DepDropHelper;
use Yii;
use app\modules\journal\models\record\JournalStudent;
use app\modules\journal\models\record\JournalStudentSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use nullref\core\interfaces\IAdminController;

/**
 * JournalStudentController implements the CRUD actions for JournalStudent model.
 */
class JournalStudentController extends Controller implements IAdminController
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
        ];
    }

    /**
     * Lists all JournalStudent models.
     * @return mixed
     */
    public function actionIndex($load_id)
    {
        $searchModel = new JournalStudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'load_id' => $load_id
        ]);
    }

    /**
     * Displays a single JournalStudent model.
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
     * Creates a new JournalStudent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($load_id)
    {
        $model = new JournalStudent(['load_id' => $load_id]);
        $model->date = date('Y-m-d');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'load_id' => $load_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing JournalStudent model.
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
     * Deletes an existing JournalStudent model.
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
     * Finds the JournalStudent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return JournalStudent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = JournalStudent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetStudents($load_id)
    {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $type = $params['journalstudent-type']; // get the value of input-type-1
                    if ($type == JournalStudent::TYPE_ACCEPTED) {
                        $out = DepDropHelper::convertMap(JournalStudent::getAvailableStudentsList($load_id));
                        echo Json::encode(['output' => $out, 'selected' => Yii::t('app', 'Select teacher')]);
                        return;
                    } elseif ($type == JournalStudent::TYPE_DE_ACCEPTED) {
                        $out = DepDropHelper::convertMap(JournalStudent::getActiveStudentsInLoadList($load_id));
                        echo Json::encode(['output' => $out, 'selected' => Yii::t('app', 'Select teacher')]);
                        return;
                    }
                }
            }
            echo Json::encode(['output' => [], 'selected' => Yii::t('app', 'Select ...')]);
            return;
        }
    }
}
