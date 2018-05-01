<?php
/**
 * @author    Yaroslav Velychko
 */

namespace app\modules\rbac\controllers;

use app\modules\rbac\filters\AccessControl;
use dektrium\rbac\controllers\RuleController as BaseRuleController;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class RuleController extends BaseRuleController
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