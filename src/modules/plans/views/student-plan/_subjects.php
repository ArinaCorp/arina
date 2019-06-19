<?php

use app\helpers\GlobalHelper;
use app\modules\plans\models\StudentPlan;
use yii\web\View;
use yii\bootstrap\Tabs;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var StudentPlan $model
 */
?><h3<?= Yii::t('plans', 'Subjects'); ?>/h3>

<?php Pjax::begin(); ?>

<?= Tabs::widget([
    'items' => [
        [
            'label' => GlobalHelper::getOrderLiteral($model->course) . ' ' . Yii::t('app', 'course'),
            'active' => true,
            'content' => $this->render('_course', ['model' => $model, 'course' => $model->course, 'semester' => $model->semester], true),
        ],
    ],
]);
?>
<?php Pjax::end(); ?>