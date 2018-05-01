<?php
/**
 * @author    Yaroslav Velychko
 */

namespace app\modules\rbac\controllers;


use app\modules\rbac\filters\AccessControl;
use dektrium\rbac\controllers\AssignmentController as BaseAssignmentController;
use dektrium\rbac\models\Assignment;
use dektrium\rbac\widgets\Assignments as AssignmentsWidget;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class AssignmentController extends BaseAssignmentController
{
    public function behaviors()
    {
        return ArrayHelper::merge([
            'access' => [
                'class' => AccessControl::class,
                'controller' => $this,
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ], parent::behaviors());
    }

    /**
     * Show form with auth items for user.
     *
     * @param int $id
     * @return string
     * @throws \Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAssign($id)
    {
        $model = Yii::createObject([
            'class' => Assignment::className(),
            'user_id' => $id,
        ]);

        if ($model->load(\Yii::$app->request->post()) && $model->updateAssignments()) {
        }

        return AssignmentsWidget::widget([
            'userId' => $id,
        ]);
    }
}