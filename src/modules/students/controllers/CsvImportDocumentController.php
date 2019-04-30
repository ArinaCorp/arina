<?php

namespace app\modules\students\controllers;

use app\modules\students\models\CreateCsvImportDocument;
use app\modules\students\models\CsvImportDocumentItem;
use Yii;
use app\modules\students\models\CsvImportDocument;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use nullref\core\interfaces\IAdminController;

/**
 * CsvImportDocumentController implements the CRUD actions for CsvImportDocument model.
 */
class CsvImportDocumentController extends Controller implements IAdminController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'delete-item' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CsvImportDocument models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CsvImportDocument::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CsvImportDocument model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getDocumentItems(),
        ]);


        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Finds the CsvImportDocument model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CsvImportDocument the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CsvImportDocument::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new CsvImportDocument model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CreateCsvImportDocument();

        if ($model->load(Yii::$app->request->post()) && $model->upload()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionRerun($id)
    {
        $model = $this->findModel($id);
        CreateCsvImportDocument::runJob($model);
        return $this->redirect(['index']);
    }

    /**
     * Updates an existing CsvImportDocument model.
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
     * Deletes an existing CsvImportDocument model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteItem($id)
    {
        $model = CsvImportDocumentItem::findOne($id);
        $document_id = $model->document_id;
        $model->delete();

        return $this->redirect(['view', 'id' => $document_id]);
    }

    public function actionDeleteMultipleItems($ids)
    {
        $ids = explode(',', $ids);
        foreach ($ids as $id) {
            $model = CsvImportDocumentItem::findOne($id);
            $document_id = $model->document_id;
            $model->delete();
        }

        return $this->redirect(['view', 'id' => $document_id]);
    }
}
