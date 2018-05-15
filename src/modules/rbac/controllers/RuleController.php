<?php
/**
 * @author    Yaroslav Velychko
 */

namespace app\modules\rbac\controllers;

use dektrium\rbac\controllers\RuleController as BaseRuleController;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class RuleController extends BaseRuleController
{
    public function behaviors()
    {
        return ArrayHelper::merge([
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ], parent::behaviors());
    }
}