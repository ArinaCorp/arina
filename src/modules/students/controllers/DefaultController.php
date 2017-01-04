<?php

namespace app\modules\students\controllers;

/* @author VasyaKog */
use app\modules\students\models\FamilyTie;
use app\modules\students\models\StudentsHistory;
use app\modules\students\models\StudentsPhones;
use yii\base\Exception;
use yii\base\Model;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use app\modules\students\models\StudentSearch;
use app\modules\students\models\Student;
use yii\web\NotFoundHttpException;

use nullref\core\interfaces\IAdminController;
use Yii;

/**
 * Default controller for the `students` module
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
     * Lists all Student models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Student model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        /**
         * @var $model Student
         */
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Student model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Student();
        $modelsFamily = [new FamilyTie()];
        $modelsPhones = [new StudentsPhones()];
        /**
         * @var $modelsFamily FamilyTie[]
         */
        if ($model->load(Yii::$app->request->post())) {
            $modelsFamily = Student::createMultiple(FamilyTie::classname());
            $modelsPhones = Student::createMultiple(StudentsPhones::className());
            Model::loadMultiple($modelsPhones, Yii::$app->request->post());
            Model::loadMultiple($modelsFamily, Yii::$app->request->post());
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsFamily) && Model::validateMultiple($modelsPhones) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsFamily as $modelFamily) {
                            $modelFamily->student_id = $model->id;
                            if (!($flag = $modelFamily->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        foreach ($modelsPhones as $modelsPhone) {
                            $modelsPhone->student_id = $model->id;
                            if (!($flag = $modelsPhone->save(false))) {
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
            'modelsFamily' => (empty($modelsFamily)) ? [new FamilyTie()] : $modelsFamily,
            'modelsPhones' => (empty($modelsPhones)) ? [new StudentsPhones()] : $modelsPhones,
        ]);
    }


    /**
     * Updates an existing Student model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public
    function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsFamily = $model->family;
        $modelsPhones = $model->phones;
        /**
         * @var $modelsFamily FamilyTie[]
         */
        if ($model->load(Yii::$app->request->post())) {
            $familyOldIDs = ArrayHelper::map($modelsFamily, 'id', 'id');
            $phonesOldIDs = ArrayHelper::map($modelsPhones, 'id', 'id');
            $modelsFamily = Student::createMultiple(FamilyTie::classname(), $modelsFamily);
            Model::loadMultiple($modelsFamily, Yii::$app->request->post());
            $familyDeletedIDs = array_diff($familyOldIDs, array_filter(ArrayHelper::map($modelsFamily, 'id', 'id')));
            $phonesDeletedIDs = array_diff($phonesOldIDs, array_filter(ArrayHelper::map($modelsFamily, 'id', 'id')));
            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsFamily) && Model::validateMultiple($modelsPhones) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (!empty($familyDeletedIDs)) {
                            FamilyTie::deleteAll(['id' => $familyDeletedIDs]);
                        }
                        foreach ($modelsFamily as $modelFamily) {
                            $modelFamily->student_id = $model->id;
                            if (!($flag = $modelFamily->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        if (!empty($phonesDeletedIDs)) {
                            FamilyTie::deleteAll(['id' => $phonesDeletedIDs]);
                        }
                        foreach ($modelsFamily as $modelFamily) {
                            $modelFamily->student_id = $model->id;
                            if (!($flag = $modelFamily->save(false))) {
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
        }

        return $this->render('update', [
            'model' => $model,
            'modelsFamily' => (empty($modelsFamily)) ? [new FamilyTie()] : $modelsFamily,
            'modelsPhones' => (empty($modelsPhones)) ? [new StudentsPhones()] : $modelsPhones,
        ]);
    }


    /**
     * Deletes an existing Student model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public
    function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected
    function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
