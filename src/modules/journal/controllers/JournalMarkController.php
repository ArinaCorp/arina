<?php

namespace app\modules\journal\controllers;

use app\components\DepDropHelper;
use app\modules\journal\models\evaluation\Evaluation;
use app\modules\journal\models\record\JournalRecordType;
use Yii;
use app\modules\journal\models\record\JournalMark;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use nullref\core\interfaces\IAdminController;

/**
 * JournalMarkController implements the CRUD actions for JournalMark model.
 */
class JournalMarkController extends Controller implements IAdminController
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
     * Lists all JournalMark models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => JournalMark::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single JournalMark model.
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
     * Creates a new JournalMark model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($student_id, $record_id)
    {
        $model = new JournalMark();
        $model->student_id = $student_id;
        $model->record_id = $record_id;
        $model->presence = true;
        $type = $model->journalRecord->typeObj;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'type' => $type,
            ]);
        }
    }

    /**
     * Updates an existing JournalMark model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $type = $model->journalRecord->typeObj;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'type' => $type,
            ]);
        }
    }

    /**
     * Deletes an existing JournalMark model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionGetEvaluationList()
    {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $system_id = $params['journalmark-evaluation_system_id']; // get the value of input-type-1
                    if (!is_null($system_id)) {
                        $out = DepDropHelper::convertMap(Evaluation::getListBySystem($system_id));
                        echo Json::encode(['output' => $out, 'selected' => Yii::t('app', 'Select teacher')]);
                        return;
                    }
                }
            }
            echo Json::encode(['output' => [], 'selected' => Yii::t('app', 'Select ...')]);
            return;
        }
    }

    /**
     * Finds the JournalMark model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return JournalMark the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = JournalMark::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
