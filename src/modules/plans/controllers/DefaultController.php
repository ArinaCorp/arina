<?php

namespace app\modules\plans\controllers;

use Yii;
use yii\web\Controller;
use nullref\core\interfaces\IAdminController;

class DefaultController extends Controller implements IAdminController
{
    public $name = 'Plans';

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionResetGraph()
    {
        unset(Yii::$app->session['weeks']);
        unset(Yii::$app->session['graph']);
    }
}