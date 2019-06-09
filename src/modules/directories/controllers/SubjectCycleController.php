<?php

namespace app\modules\directories\controllers;

use Yii;
use nullref\core\interfaces\IAdminController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\directories\models\subject_cycle\SubjectCycle;
use yii\web\Response;

/**
 * SubjectCycle implements the CRUD actions for SubjectCycle model.
 */
class SubjectCycleController extends Controller implements IAdminController
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
     * @param int $id
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex($id = 0)
    {
        $subjectCycles = SubjectCycle::getTree();
        /** @var SubjectCycle $model */
        $model = new SubjectCycle();
        $formName = $model->formName();
        return $this->render('index', [
            'subjectCycles' => $subjectCycles,
            'id' => $id,
            'formName' => $formName,
        ]);
    }

    /**
     * @param integer $id
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
     * Finds the SubjectCycle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SubjectCycle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SubjectCycle::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new SubjectCycle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param int $parent_id
     * @return mixed
     */
    public function actionCreate($parent_id = SubjectCycle::ROOT_ID)
    {
        $model = new SubjectCycle([
            'parent_id' => $parent_id
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->parentCycle ? $model->parentCycle->id : 0]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        /** @var SubjectCycle $model */
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => !$model->hasErrors(),
                    'errors' => $model->getFirstErrors(),
                ];
            }
            return $this->redirect(['index', 'id' => $model->parentCycle ? $model->parentCycle->id : 0]);
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'model' => $model,
            ];
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SubjectCycle model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        /** @var SubjectCycle $model */
        $model = $this->findModel($id);
        $model->delete();

        return $this->redirect(['index', 'id' => $model->parentCycle ? $model->parentCycle->id : 0]);
    }
}
