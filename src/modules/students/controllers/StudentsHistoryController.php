<?php

namespace app\modules\students\controllers;

use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\students\models\Group;
use app\modules\students\models\StudentsHistoryAll;
use app\modules\students\models\StudentsHistoryBefore;
use app\modules\students\models\StudentsHistoryCourse;
use app\modules\students\models\StudentsHistoryGroup;
use app\modules\students\models\StudentsHistoryPayment;
use Yii;
use app\modules\students\models\StudentsHistory;
use app\modules\students\models\StudentsHistorySearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use nullref\core\interfaces\IAdminController;
use app\components\DepDropHelper;

/**
 * StudentsHistoryController implements the CRUD actions for StudentsHistory model.
 */
class StudentsHistoryController extends Controller implements IAdminController
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
     * Lists all StudentsHistory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentsHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentsHistory model.
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
     * Creates a new StudentsHistoryBefore model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StudentsHistoryBefore();
        $model->date = date('d.m.Y');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(['create-end', $model->attributes]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateEnd()
    {
        switch (Yii::$app->request->get()[1]['action_type']) {
            case StudentsHistory::$TYPE_INCLUDE :
            case StudentsHistory::$TYPE_RENEWAL :
            case StudentsHistory::$TYPE_TRANSFER_SPECIALITY_QA : {
                $model = new StudentsHistoryAll();
                break;
            }
            case StudentsHistory::$TYPE_TRANSFER_COURSE : {
                $model = new StudentsHistoryCourse();
                break;
            }
            case StudentsHistory::$TYPE_TRANSFER_GROUP : {
                $model = new StudentsHistoryGroup();
                break;
            }
            case StudentsHistory::$TYPE_TRANSFER_FOUNDING : {
                $model = new StudentsHistoryPayment();
                break;
            }
            case StudentsHistory::$TYPE_EXCLUDE : {
                $model = new StudentsHistory();
                break;
            }
        }
        $model->setAttributes(Yii::$app->request->get()[1], false);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('create-end',
                [
                    'model' => $model,
                ]
            );
        }
    }


    /**
     * Deletes an existing StudentsHistory model.
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
     * Finds the StudentsHistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentsHistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected
    function findModel($id)
    {
        if (($model = StudentsHistory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public
    function actionGetGroupsList()
    {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $category_id = $params['studentshistorybefore-category_id']; // get the value of input-type-1
                    switch ($category_id) {
                        case StudentsHistory::CATEGORY_NEW: {
                            $out[] = ['id' => 1, 'name' => Yii::t('app', 'All')];
                            break;
                        }
                        case StudentsHistory::CATEGORY_ACTIVE: {
                            $out = DepDropHelper::convertMap(Group::getActiveGroupsList());
                            break;
                        }
                        case StudentsHistory::CATEGORY_ALUMNUS: {
                            $out = DepDropHelper::convertMap(Group::getAllGroupsList());
                            break;
                        }
                        default: {
                            break;
                        }
                    }
                    echo Json::encode(['output' => $out, 'selected' => Yii::t('app', 'Select ...')]);
                    return;
                }
            }
            echo Json::encode(['output' => [], 'selected' => Yii::t('app', 'Select ...')]);
            return;
        }
    }

    public
    function actionGetStudentsList()
    {

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $category_id = $params['studentshistorybefore-category_id'];
                    $group_id = $params['studentshistorybefore-group_search_id'];
                    switch ($category_id) {
                        case StudentsHistory::CATEGORY_NEW: {
                            $out = DepDropHelper::convertMap(StudentsHistory::getNewStudentList());
                            break;
                        }
                        case StudentsHistory::CATEGORY_ACTIVE: {
                            $out = DepDropHelper::convertMap(StudentsHistory::getActiveStudentByGroupList($group_id));
                            break;
                        }
                        case StudentsHistory::CATEGORY_ALUMNUS: {
                            $out = DepDropHelper::convertMap(StudentsHistory::getAlumnusStudentByGroupList($group_id));
                            break;
                        }
                        default: {
                            break;
                        }
                    }
                }
            }
        }
        echo Json::encode(['output' => $out, 'selected' => Yii::t('app', 'Select ...')]);
        return;
    }

    public
    function actionGetStudentParents()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $student_id = $params['studentshistorybefore-student_id'];
                    $out = DepDropHelper::convertMap(StudentsHistory::getStudentParentsList($student_id));
                }
            }
        }
        echo Json::encode(['output' => $out, 'selected' => Yii::t('app', 'Select ...')]);
        return;
    }

    public
    function actionGetPermittedActions()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $parent_id = $params['studentshistorybefore-parent_id'];
                    $out = DepDropHelper::convertMap(StudentsHistory::getPermittedActionList($parent_id));
                }
            }
        }
        echo Json::encode(['output' => $out, 'selected' => Yii::t('app', 'Select ...')]);
        return;
    }

    public
    function actionGetGroupsListFromSpecialityQualification()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $speciality_qualification_id = $params['studentshistoryall-speciality_qualification_id'];
                    $out = DepDropHelper::convertMap(SpecialityQualification::findOne(['id' => $speciality_qualification_id])->getGroupsActiveList());
                }
            }
        }
        echo Json::encode(['output' => $out, 'selected' => Yii::t('app', 'Select ...')]);
        return;
    }

    public
    function actionGetCoursesGroup()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $group_id = $params['studentshistoryall-group_id'];
                    $out = DepDropHelper::convertMap(Group::findOne(['id' => $group_id])->getCoursesList());
                }
            }
        }
        echo Json::encode(['output' => $out, 'selected' => Yii::t('app', 'Select ...')]);
        return;
    }
}
