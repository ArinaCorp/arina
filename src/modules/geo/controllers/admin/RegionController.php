<?php

namespace app\modules\geo\controllers\admin;

use app\components\DepDropHelper;
use app\modules\geo\models\City;
use app\modules\geo\models\RegionSearch;
use nullref\core\interfaces\IAdminController;
use tigrov\country\Subregion;
use Yii;
use app\modules\geo\models\Region;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * RegionController implements the actions for Region model.
 */
class RegionController extends Controller implements IAdminController
{
    public function behaviors()
    {
        return [

        ];
    }

    /**
     * Lists all Regions.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Region model.
     * @param $country_code string
     * @param $division_code string
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($country_code, $division_code)
    {
        $model = $this->findModel($country_code, $division_code);

//        var_dump(array_merge($model->fields(),$model->extraFields())); die;

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Region model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param $country_code string
     * @param $division_code string
     * @return Region|bool the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($country_code, $division_code)
    {
        if (($model = Region::findOne(['country_code' => $country_code, 'division_code' => $division_code])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionGetCountryRegions()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = '';
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $country_id = $parents[0];
                $regions = Region::getMap('name', 'division_code', ['country_code' => $country_id], false);
                $out = DepDropHelper::convertMap($regions);
            }
        }
        return ['output' => $out, 'selected' => ''];
    }
}
