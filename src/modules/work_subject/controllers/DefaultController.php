<?php

namespace app\modules\work_subject\controllers;

use app\modules\work_subject\models\WorkSubjectSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
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


    //TODO: finish contoller
    public function actionIndex()
    {
        $searchModel = new WorkSubjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
