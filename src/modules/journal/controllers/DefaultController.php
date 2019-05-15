<?php

namespace app\modules\journal\controllers;

use app\components\DepDropHelper;
use app\modules\directories\models\StudyYear;
use app\modules\journal\models\record\JournalMark;
use app\modules\journal\models\record\JournalRecord;
use app\modules\journal\models\record\JournalStudent;
use app\modules\journal\models\reports\SubjectReport;
use app\modules\journal\models\SelectForm;
use app\modules\load\models\Load;
use app\modules\rbac\filters\AccessControl;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `journal` module
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
                'class' => VerbFilter::class,
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [],
                        'roles' => ['teacher'],
                    ]
                ]
            ]
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $model = new SelectForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(['view', 'id' => $model->load_id]);
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $list = JournalRecord::getByLoadArray($model->id);
        $students = JournalStudent::getAllStudentByLoad($model->id);
        $map = JournalMark::getMap($students, $list);
        return $this->render('view', [
            'model' => $model,
            'list' => $list,
            'students' => $students,
            'map' => $map,
        ]);
    }

    /**
     * @param $id
     * @return Load|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Load::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     */
    public function actionDocument($id)
    {
        return SubjectReport::getReport($id);
    }

    /**
     * @return string
     */
    public function actionGetGroups()
    {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $year_id = $params['selectform-year_id']; // get the value of input-type-1
                    $speciality_qualification_id = $params['selectform-speciality_qualification_id']; // get the value of input-type-1
                    if ($year_id && $speciality_qualification_id) {
                        $out = DepDropHelper::convertMap(StudyYear::getListGroupByYear($speciality_qualification_id, $year_id));
                        return Json::encode(['output' => $out, 'selected' => Yii::t('app', 'Select teacher')]);
                    }
                }
            }
            return Json::encode(['output' => [], 'selected' => Yii::t('app', 'Select ...')]);
        }
    }

    /**
     * @return string
     */
    public function actionGetLoads()
    {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                if (!empty($_POST['depdrop_all_params'])) {
                    $params = $_POST['depdrop_all_params'];
                    $year_id = $params['selectform-year_id']; // get the value of input-type-1
                    $group_id = $params['selectform-group_id']; // get the value of input-type-1
                    if ($year_id && $group_id) {
                        $out = DepDropHelper::convertMap(Load::getListByGroupAndYear($group_id, $year_id));
                        return Json::encode(['output' => $out, 'selected' => Yii::t('app', 'Select teacher')]);
                    }
                }
            }
            return Json::encode(['output' => [], 'selected' => Yii::t('app', 'Select ...')]);
        }
    }
}
