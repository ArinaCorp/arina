<?php

namespace app\modules\students\controllers;

use yii\web\Controller;

/**
 * Default controller for the `students` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
