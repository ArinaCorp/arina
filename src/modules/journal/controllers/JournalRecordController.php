<?php

namespace app\modules\journal\controllers;

use app\modules\journal\models\record\JournalRecord;
use app\modules\journal\models\record\JournalRecordFirst;
use app\modules\load\models\Load;
use Yii;
use app\modules\journal\models\record\JournalRecordType;
use app\modules\journal\models\record\JournalRecordTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use nullref\core\interfaces\IAdminController;

/**
 * JournalRecordController implements the CRUD actions for JournalRecordType model.
 */
class JournalRecordController extends Controller implements IAdminController
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
     * Lists all JournalRecordType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JournalRecordTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single JournalRecordType model.
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
     * Creates a new JournalRecordType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($load_id, $type)
    {
        $model = new JournalRecord();
        $model->load_id = $load_id;
        $model->type = $type;
        $model->date = date('Y-m-d');
        $typeObj = JournalRecordType::findOne($type);
        //     $model->teacher_id = Load::findOne($load_id)->employee_id;
        $model->teacher_id = Load::getZaglushka()->employee_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'type' => $typeObj,
                'model' => $model,
            ]);
        }
    }

    public function actionCreateFirst($load_id)
    {
        $model = new JournalRecordFirst();
        $model->load_id = $load_id;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(['create', 'load_id' => $model->load_id, 'type' => $model->type]);
        } else {
            return $this->render('create-first', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing JournalRecordType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $typeObj = JournalRecordType::findOne($model->type);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'type' => $typeObj,
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing JournalRecordType model.
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
     * Finds the JournalRecord  model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return JournalRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = JournalRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
