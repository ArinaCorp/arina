<?php

namespace app\modules\work_subject\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;
use app\modules\work_subject\models\WorkSubject;
use yii\web\NotFoundHttpException;
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

}
