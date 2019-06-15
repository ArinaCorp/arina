<?php

namespace app\modules\accounting\controllers;

use app\modules\accounting\models\HourAccountingRecord;
use app\modules\load\models\Load;
use Yii;
use app\modules\accounting\models\YearlyHourAccounting;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use nullref\core\interfaces\IAdminController;

/**
 * YearlyHourAccountingController implements the CRUD actions for YearlyHourAccounting model.
 */
class YearlyHourAccountingController extends Controller implements IAdminController
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
     * Lists all YearlyHourAccounting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => YearlyHourAccounting::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single YearlyHourAccounting model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $loads = Load::find()
            ->joinWith('group')
            ->joinWith('workSubject')
            ->joinWith('workSubject.subject')
            ->where([
                'employee_id' => $model->teacher_id,
                'study_year_id' => $model->study_year_id,
            ])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'loads' => $loads,
        ]);
    }

    /**
     * Finds the YearlyHourAccounting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return YearlyHourAccounting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = YearlyHourAccounting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param int $recordId
     * @param int $monthIndex
     * @return \yii\web\Response
     */
    public function actionSetMonthHour($recordId, $monthIndex = 0)
    {
        if (!is_null($monthHour = Yii::$app->request->post('monthHour'))) {
            $record = HourAccountingRecord::findOne(['id' => $recordId]);
            $hoursPerMonth = $record->hours_per_month;
            $hoursPerMonth[(int)$monthIndex] = (int)$monthHour;
            $record->hours_per_month = $hoursPerMonth;
            if ($record->save()) {
                return $this->asJson([
                    'message' => Yii::t('app', 'Updated')
                ]);
            }
        }
    }

    /**
     * Creates a new YearlyHourAccounting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new YearlyHourAccounting();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing YearlyHourAccounting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
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
     * Deletes an existing YearlyHourAccounting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}
