<?php

namespace app\modules\students\controllers;

use app\modules\students\models\File;
use yii\filters\VerbFilter;
use yii\web\Controller;
use app\modules\students\models\Student;

use nullref\core\interfaces\IAdminController;
use Yii;
use yii\web\UploadedFile;

/**
 * @author VasyaKog
 */
class ImportController extends Controller implements IAdminController
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

    public function actionIndex()
    {
        $model = new File();
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $result = Student::importXml($model);
            return $this->render(
                'result',
                [
                    'result' => $result
                ]
            );
        }
        return $this->render('index',
            [
                'model' => $model
            ]);
    }
}