<?php

namespace app\controllers;

use app\modules\directories\models\StudyYear;
use app\modules\load\models\Load;
use app\modules\rbac\filters\AccessControl;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use app\modules\journal\widgets\MarksAccounting;
use nullref\core\interfaces\IAdminController;
use nullref\core\models\Model;
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

    public function actionIndex($load_id = null)
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        $widgets = [];

        if (UserHelper::hasRole($user, 'teacher')) {
            $current_year = StudyYear::getCurrentYear();
            $loads = Load::find()
                ->joinWith('workSubject.subject')
                ->joinWith('group')
                ->where([
//                    'employee_id' => $user->employee_id,
//                    'study_year_id' => $current_year->id,
                    'employee_id' => 2,
                    'study_year_id' => 6,
                ])->getMap('fullTitle');

            $widgets[] = MarksAccounting::widget([
                'loads' => $loads,
                'load_id' => $load_id
            ]);
        }

        return $this->render('index', ['widgets' => $widgets]);
    }
}
