<?php

use yii\web\View;
use yii\bootstrap\Tabs;

use app\modules\plans\models\WorkPlan;

/**
 * @var View $this
 * @var WorkPlan $model
 */
?>
    <h3>Предмети</h3>
<?= Tabs::widget([
    'items' => [
        [
            'label' => '1-й курс',
            'active' => true,
            'content' => $this->render('_course', ['model' => $model, 'course' => 1], true),
        ],
        [
            'label' => '2-й курс',
            'active' => true,
            'content' => $this->render('_course', ['model' => $model, 'course' => 2], true),
        ],
        [
            'label' => '3-й курс',
            'active' => true,
            'content' => $this->render('_course', ['model' => $model, 'course' => 3], true),
        ],
        [
            'label' => '4-й курс',
            'active' => true,
            'content' => $this->render('_course', ['model' => $model, 'course' => 4], true),
        ],
    ],
]);
?>
