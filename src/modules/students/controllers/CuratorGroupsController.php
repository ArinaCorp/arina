<?php

namespace app\modules\students\controllers;

use app\components\DepDropHelper;
use app\modules\employee\models\Employee;
use app\modules\students\models\Group;
use Yii;
use app\modules\students\models\CuratorGroup;
use app\modules\students\models\CuratorGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use nullref\core\interfaces\IAdminController;
use yii\helpers\Json;

/**
 * CuratorGroupController implements the CRUD actions for CuratorGroup model.
 */
class CuratorGroupsController extends Controller implements IAdminController
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
     * Lists all CuratorGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CuratorGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CuratorGroup model.
     * @param integer $id
     * @return mixed
     */
//    public function actionView($id)
//    {
//        return $this->render('view', [
//            'model' => $this->findModel($id),
//        ]);
//    }

    /**
     * Creates a new CuratorGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CuratorGroup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CuratorGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Deletes an existing CuratorGroup model.
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
     * Finds the CuratorGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CuratorGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CuratorGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetTeachersList()
    {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $group_id = $params['curatorgroup-group_id']; // get the value of input-type-1
                    $type = $params['curatorgroup-type']; // get the value of input-type-1
                    if ($group_id && $type) {
                        switch ($type) {
                            case CuratorGroup::TYPE_DE_ACCEPTED: {
                                $curator = Group::findOne(['id' => $group_id])->getCurator();
                                /**
                                 * @var $curator Employee;
                                 */
                                return Json::encode(['output' => [['id' => $curator->id, 'name' => $curator->getFullName()]], 'selected' => ['id' => $curator->id, 'name' => $curator->getFullName()]]);
                            }
                            case CuratorGroup::TYPE_ACCEPTED: {
                                $out = DepDropHelper::convertMap(Employee::getMap('nameWithInitials', 'id', [], false));
                                return Json::encode(['output' => $out, 'selected' => Yii::t('app', 'Select teacher')]);
                            }
                            default: {
                                break;
                            }
                        }
                        ;
                    }
                }
            }
            return Json::encode(['output' => [], 'selected' => Yii::t('app', 'Select ...')]);
        }
    }

    public function actionGetTypesList()
    {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $group_id = $params['curatorgroup-group_id']; // get the value of input-type-1
                    $group = Group::findOne(['id' => $group_id]);
                    if ($group->getCuratorId() === false) {
                        echo Json::encode(['output' => [['id' => CuratorGroup::TYPE_ACCEPTED, 'name' => CuratorGroup::getTypesList()[CuratorGroup::TYPE_ACCEPTED]]], 'selected' => ['id' => CuratorGroup::TYPE_ACCEPTED, 'name' => CuratorGroup::getTypesList()[CuratorGroup::TYPE_ACCEPTED]]]);
                    } else {
                        echo Json::encode(['output' => [['id' => CuratorGroup::TYPE_DE_ACCEPTED, 'name' => CuratorGroup::getTypesList()[CuratorGroup::TYPE_DE_ACCEPTED]]], 'selected' => ['id' => CuratorGroup::TYPE_DE_ACCEPTED, 'name' => CuratorGroup::getTypesList()[CuratorGroup::TYPE_DE_ACCEPTED]]]);
                    }
                }
            }
        }
        return;
    }
}
