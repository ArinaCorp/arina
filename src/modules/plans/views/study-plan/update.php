<?php

use yii\web\View;
use yii\bootstrap\Html;

use app\modules\plans\models\StudyPlan;
use app\modules\plans\widgets\SubjectTable;

/**
 * @var $this View
 * @var $model StudyPlan
 */

$this->title = Yii::t('plans', 'Edit study plan');

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Study plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', ['id' => $model->id, 'graph'=>$model->graphs]]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="study-plan-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?= Html::a(Yii::t('plans', 'Edit subjects'), ['subjects', ['id' => $model->id]], ['class' => 'btn btn-default']) ?>

    <?= Html::a(Yii::t('base', 'Return'), ['index'], ['class' => 'btn btn-danger']) ?>

</div>