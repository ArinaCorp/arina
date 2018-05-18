<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Response;

/**
 *
 */
class MainController extends \nullref\admin\controllers\MainController
{
    /**
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}