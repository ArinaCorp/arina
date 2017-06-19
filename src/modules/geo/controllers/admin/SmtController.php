<?php

namespace app\modules\geo\controllers\admin;

use app\modules\geo\models\District;
use nullref\core\interfaces\IAdminController;
use Yii;
use app\modules\geo\models\City;
use app\modules\geo\models\Region;
use app\modules\geo\models\Smt;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CityController implements the CRUD actions for City model.
 */
class SmtController extends Controller implements IAdminController
{
    /**
     * @var string
     */
    public $modelClass;
    public $modelRegionClass;
    public $modelDistrictClass;

    public function init()
    {
        parent::init();
        if ($this->modelClass === null) {
            $this->modelClass = Smt::className();
        }
        if ($this->modelRegionClass === null) {
            $this->modelRegionClass = Region::className();
        }
        if ($this->modelDistrictClass === null) {
            $this->modelDistrictClass = District::className();
        }
    }

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
     * Lists all Smt models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => call_user_func([$this->modelClass, 'find'])->joinWith(['country','region','district']),
            'sort' => [
                'attributes' => [
                    'name' => [
                        'asc' => [
                            'name' => SORT_ASC
                        ],
                        'desc' => [
                            'name' => SORT_DESC
                        ],
                    ],
                    'country' => [
                        'asc' => ['country.name' => SORT_ASC],
                        'desc' => ['country.name' => SORT_DESC],
                    ],
                    'region' => [
                        'asc' => ['region.name' => SORT_ASC],
                        'desc' => ['region.name' => SORT_DESC],
                    ],
                    'district' => [
                        'asc' => ['district.name' => SORT_ASC],
                        'desc' => ['district.name' => SORT_DESC],
                    ],
                ],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Smt model.
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
     * Creates a new Smt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = Yii::createObject($this->modelClass);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Smt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
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
     * Deletes an existing Smt model.
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
     * Finds the Smt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Smt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = call_user_func([$this->modelClass, 'findOne'], [$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function getRegions($country_id)
    {
        $regions = call_user_func([$this->modelRegionClass, 'find'])->where(['country_id' => $country_id])->all();
        $regionList = [];
        /** @var Region $region */
        foreach ($regions as $region) {
            $regionList[] = [
                'id' => $region->id,
                'name' => $region->name,
            ];
        }
        return $regionList;
    }

    public function actionRegion()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $country_id = $parents[0];
                $out = self::getRegions($country_id);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

    public function getDistricts($region_id)
    {
        $districts = call_user_func([$this->modelDistrictClass, 'find'])->where(['region_id' => $region_id])->all();
        $districtList = [];
        foreach ($districts as $district) {
            $districtList[] = [
                'id' => $district->id,
                'name' => $district->name,
            ];
        }
        return $districtList;
    }

    public function actionDistrict()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $district_id = $parents[0];
                $out = self::getDistricts($district_id);
                echo Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }

}
