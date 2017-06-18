<?php

use yii\web\View;
use yii\bootstrap\Tabs;
use yii\widgets\Pjax;

use app\modules\plans\models\WorkPlan;

/**
 * @var View $this
 * @var WorkPlan $model
 */
?><h3<?= Yii::t('plans', 'Subjects'); ?>/h3>

<?php Pjax::begin(); ?>

<?= Tabs::widget([
    'items' => [
        [
            'label' => Yii::t('app', 'First').' '.Yii::t('app', 'course'),
            'active' => true,
            'content' => $this->render('_course', ['model' => $model, 'course' => 1,
                    'subjectDataProvider' => $model->getWorkPlanSubjectProvider()], true),
        ],
        [
            'label' => Yii::t('app', 'Second').' '.Yii::t('app', 'course'),
            'active' => true,
            'content' => $this->render('_course', ['model' => $model, 'course' => 2,
                'subjectDataProvider' => $model->getWorkPlanSubjectProvider()], true),
        ],
        [
            'label' => Yii::t('app', 'Third').' '.Yii::t('app', 'course'),
            'active' => true,
            'content' => $this->render('_course', ['model' => $model, 'course' => 3,
                'subjectDataProvider' => $model->getWorkPlanSubjectProvider()], true),
        ],
        [
            'label' => Yii::t('app', 'Fourth').' '.Yii::t('app', 'course'),
            'active' => true,
            'content' => $this->render('_course', ['model' => $model, 'course' => 4,
                'subjectDataProvider' => $model->getWorkPlanSubjectProvider()], true),
        ],
    ],
]);
?>
<?php Pjax::end(); ?>