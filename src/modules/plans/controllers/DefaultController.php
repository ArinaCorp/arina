<?php

namespace app\modules\plans\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;
use nullref\core\interfaces\IAdminController;

/**
 * Default controller for the `plans` module
 */
class DefaultController extends Controller implements IAdminController
{
    public $name = 'Plans';

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

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}