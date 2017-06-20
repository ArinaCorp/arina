<?php

namespace app\modules\journal\controllers;

use app\components\DepDropHelper;
use app\modules\directories\models\StudyYear;
use app\modules\journal\models\SelectForm;
use nullref\core\interfaces\IAdminController;
use yii\helpers\Json;
use yii\web\Controller;
use Yii;
use app\modules\load\models\Load;

/**
 * Default controller for the `journal` module
 */
class DefaultController extends Controller implements IAdminController
{
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

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

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
                        echo Json::encode(['output' => $out, 'selected' => Yii::t('app', 'Select teacher')]);
                        return;
                    }
                }
            }
            echo Json::encode(['output' => [], 'selected' => Yii::t('app', 'Select ...')]);
            return;
        }
    }

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
                        echo Json::encode(['output' => $out, 'selected' => Yii::t('app', 'Select teacher')]);
                        return;
                    }
                }
            }
            echo Json::encode(['output' => [], 'selected' => Yii::t('app', 'Select ...')]);
            return;
        }
    }

    protected function findModel($id)
    {
        if ($id == 228) return Load::getZaglushka();
    }
}
