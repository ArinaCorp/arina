<?php

namespace app\modules\students\controllers;

use app\modules\students\models\FileExcel;
use app\modules\students\models\FileXml;
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
        $model = new FileXml();
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

    public function actionExcel()
    {
        $model = new FileExcel();
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $result = Student::importExcel($model);
            return $this->render(
                'result',
                [
                    'result' => $result
                ]
            );
        }
        return $this->render('excel',
            [
                'model' => $model
            ]);
    }
}