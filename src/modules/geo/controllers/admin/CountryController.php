<?php

namespace app\modules\geo\controllers\admin;

use app\modules\geo\models\Country;
use app\modules\geo\models\CountrySearch;
use nullref\core\interfaces\IAdminController;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CountryController implements the actions for Country model.
 */
class CountryController extends Controller implements IAdminController
{

    public function behaviors()
    {
        return [

        ];
    }

    /**
     * Lists all Countries.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CountrySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Country model.
     * @param integer $id Country Code
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

//        var_dump(array_merge($model->fields(),$model->extraFields())); die;

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Country model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param $id string
     * @return Country|bool the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Country::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
