<?php
/**
 * @author    Yaroslav Velychko
 */

namespace app\modules\rbac\controllers;


use app\modules\rbac\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use dektrium\rbac\controllers\AssignmentController as BaseAssignmentController;

class AssignmentController extends BaseAssignmentController
{
    public function behaviors()
    {
        return ArrayHelper::merge([
            'access' => [
                'class' => AccessControl::className(),
                'controller' => $this,
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ], parent::behaviors());
    }
}