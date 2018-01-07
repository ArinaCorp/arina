<?php

namespace app\modules\students\controllers;

/* @author VasyaKog */
use app\modules\students\models\FamilyRelation;
use app\modules\students\models\StudentCharacteristic;
use app\modules\students\models\StudentsEmail;
use app\modules\students\models\StudentsHistory;
use app\modules\students\models\StudentSocialNetwork;
use app\modules\students\models\StudentsPhone;
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
        $modelsFamily = [new FamilyRelation()];
        $modelsPhones = [new StudentsPhone()];
        /**
         * @var $modelsFamily FamilyRelation[]
         * @var $modelsPhones StudentsPhone[]
         */
        if ($model->load(Yii::$app->request->post())) {
            $modelsFamily = Student::createMultiple(FamilyRelation::classname());
            $modelsPhones = Student::createMultiple(StudentsPhone::className());
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
                        foreach ($modelsPhones as $modelPhone) {
                            $modelPhone->student_id = $model->id;
                            if (!($flag = $modelPhone->save(false))) {
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
            'modelsFamily' => (empty($modelsFamily)) ? [new FamilyRelation()] : $modelsFamily,
            'modelsPhones' => (empty($modelsPhones)) ? [new StudentsPhone()] : $modelsPhones,
        ]);
    }


    /**
     * Updates an existing Student model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id = null)
    {
        if (empty($id)) {
            $model = new Student();
        } else {
            $model = $this->findModel($id);
        }


        $model->has_family = FamilyRelation::getList($id, $model);
        $model->has_phones = StudentsPhone::getList($id, $model);
        $model->has_emails = StudentsEmail::getList($id, $model);
        $model->has_socials = StudentSocialNetwork::getList($id, $model);
        $model->has_characteristics = StudentCharacteristic::getList($id, $model);

        /**
         * @var $modelsFamily FamilyRelation[]
         */

        $saveAction = Yii::$app->request->post('save');
        $newRecord = $model->isNewRecord;
        if ($model->load(Yii::$app->request->post()) && $saveAction && $model->save()) {
            if (!Yii::$app->request->post('stay')) {
                return $this->redirect(Yii::$app->user->getReturnUrl(['/students/default']));
            } else {
                Yii::$app->session->setFlash('save-record-student', Yii::t('app', 'Student record is saved!'));
                if ($newRecord) {
                    return $this->redirect(['update', 'id' => $model->primaryKey]);
                } else {
                    return $this->refresh();
                }
            }
        } else {

            return $this->render('update', [
                'model' => $model,
                'modelsFamily' => $model->has_family,
                'modelsPhones' => $model->has_phones,
                'modelsEmails' => $model->has_emails,
                'modelsSocials' => $model->has_socials,
                'modelsCharacteristics' => $model->has_characteristics,
            ]);
        }
    }


    /**
     * Deletes an existing Student model.
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
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionTest($id)
    {
        $model = $this->findModel($id);

        echo '<pre>';
        print_r($model->emails);
    }
}
