<?php

use app\modules\plans\models\StudentPlan;
use yii\bootstrap\Html;
use yii\web\View;
use yii\helpers\Url;

use app\modules\plans\models\WorkPlan;
use app\modules\plans\widgets\Graph;

/**
 * @var $this View
 * @var $model StudentPlan
 */

$this->title = $model->student->groups[0]->specialityQualification->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Student plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <h1><?= Html::encode($model->student->fullName) ?></h1>
    <h2><?= Html::encode('Навчальний рік: ' . $model->workPlan->getYearTitle()) ?></h2>
    <h3><?= Html::encode($this->title . ', курс: ' . $model->student->groups[0]->getCourse()); ?></h3>

    <h4><?= $model->created; ?></h4>

    <?= Html::a(Yii::t('app', 'Export'), Url::toRoute(['student-plan/export', 'id' => $model->id]), ['class' => 'btn btn-success']); ?>

    <?= Html::a(Yii::t('app', 'Update'), Url::toRoute(['student-plan/update', 'id' => $model->id]), ['class' => 'btn btn-info']); ?>

    <br/><br/>

    <?= $this->render('_subjects', ['model' => $model]); ?>
</div>