<?php

use yii\bootstrap\Html;
use yii\web\View;
use yii\helpers\Url;

use app\modules\plans\models\WorkPlan;
use app\modules\plans\widgets\Graph;

/**
 * @var $this View
 * @var $model WorkPlan
 */

$this->title = $model->specialityQualification->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Study plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <h1><?= Html::encode($this->title . ' ' . $model->getYearTitle()); ?></h1>

    <h4><?= $model->getAttributeLabel('created') . ': ' . date('d.m.Y', $model->created); ?></h4>

    <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-danger']) ?>

    <?= Html::a(Yii::t('app', 'Export'), Url::toRoute(['work-plan/export', 'id' => $model->id]), ['class' => 'btn btn-success']); ?>

    <?= Html::a(Yii::t('app', 'Update'), Url::toRoute(['work-plan/update', 'id' => $model->id]), ['class' => 'btn btn-info']); ?>

    <?= Html::a(Yii::t('plans', 'Update graph'), Url::toRoute(['work-plan/graph', 'id' => $model->id]), ['class' => 'btn btn-warning']); ?>

    <?= Html::a(Yii::t('plans', 'Add subject'), Url::toRoute(['work-plan/create-subject', 'id' => $model->id]), ['class' => 'btn btn-primary']); ?>

    <br/><br/>

    <?= Graph::widget(
        [
            'model' => $model,
            'field' => '',
            'readOnly' => true,
            'graph' => $model->graph,
            'speciality_qualification_id' => $model->speciality_qualification_id,
            'study_year_id' => $model->study_year_id,
            'studyPlan' => false
        ]
    ) ?>

    <?= $model->checkSubjects(); ?>

    <?= $this->render('_subjects', ['model' => $model]); ?>
</div>