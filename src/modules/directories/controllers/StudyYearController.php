<?php

namespace app\modules\directories\controllers;

use nullref\core\interfaces\IAdminController;
use nullref\core\interfaces\IAdminModule;
use Yii;
use app\modules\directories\models\study_year\StudyYear;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StudyYearController implements the CRUD actions for StudyYear model.
 */
class StudyYearController extends Controller implements IAdminController
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
        ];
    }

    /**
     * Lists all StudyYear models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => StudyYear::find(),
        ]);
        $dataProvider->setSort([
            'attributes' => [
                'title' => [
                    'asc' => [
                        'year_start' => SORT_ASC,
                    ],
                    'desc' => [
                        'year_start' => SORT_DESC,
                    ],
                ],
                'active',
            ],
        ]);

        $currentYear = StudyYear::getActiveYear();
        $studyYears = StudyYear::find()
            ->orderBy(['year_start' => SORT_ASC])
            ->getMap('title');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'currentYear' => $currentYear,
            'studyYears' => $studyYears
        ]);
    }


    /**
     * Creates a new StudyYear model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StudyYear();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionSetCurrentYear($id)
    {
        $model = $this->findModel($id);
        if ($model->setCurrent()) {
            return $this->asJson([
                'message' => Yii::t('app', '{study_year} has been set as current study year', ['study_year' => $model->title])
            ]);
        }
    }

    /**
     * Finds the StudyYear model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudyYear the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudyYear::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Updates an existing StudyYear model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing StudyYear model.
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
