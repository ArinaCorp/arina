<?php
/**
 * @author    Yaroslav Velychko
 */

namespace app\modules\rbac\controllers;

use dektrium\rbac\controllers\RuleController as BaseRuleController;
use nullref\core\interfaces\IAdminController;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class RuleController extends BaseRuleController implements IAdminController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge([
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ], parent::behaviors());
    }
}