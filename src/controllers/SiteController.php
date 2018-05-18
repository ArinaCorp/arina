<?php

namespace app\controllers;

use app\modules\rbac\filters\AccessControl;
use nullref\core\interfaces\IAdminController;
use yii\filters\AccessRule;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SiteController extends Controller implements IAdminController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'class' => AccessRule::class,
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => [
                            'logout', 'index'
                        ],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}
