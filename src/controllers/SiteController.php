<?php

namespace app\controllers;

use app\modules\rbac\filters\AccessControl;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use nullref\core\interfaces\IAdminController;
use Yii;
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

    /**
     * @return string
     */
    public function actionIndex()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;
        $role = null;
        if ($user) {
            switch ($user) {
                case UserHelper::isStudent($user):
                    $role = User::ROLE_STUDENT;
                    break;
            }
        }

        return $this->render('index', ['role' => $role]);
    }
}
