<?php

namespace app\modules\plans\controllers;

use Yii;
use yii\base\Controller;

class DefaultController extends Controller
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