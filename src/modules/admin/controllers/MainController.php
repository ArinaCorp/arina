<?php

namespace app\modules\admin\controllers;

use Yii;

/**
 *
 */
class MainController extends \nullref\admin\controllers\MainController
{
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}