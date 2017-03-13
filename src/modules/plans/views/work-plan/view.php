<?php

use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap\Html;

use app\modules\plans\models\WorkPlan;
use app\modules\plans\widgets\Graph;

/**
 * @var View $this
 * @var WorkPlan $model
 */
$this->title = $model->speciality->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Work plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <h1><?php echo $model->speciality->title; ?></h1>

    <h4><?= $model->getAttributeLabel('created').': '.date('d.m.Y', $model->created); ?></h4>

    <?= Html::a(Yii::t('plans', 'Export'), Url::toRoute(['work-plan/make-excel', 'id' => $model->id]), ['class' => 'btn btn-success']); ?>

    <?= Html::a(Yii::t('plans', 'Update'), Url::toRoute(['work-plan/update', 'id' => $model->id]), ['class' => 'btn btn-info']); ?>

    <?= Html::a(Yii::t('plans', 'Add subject'), Url::toRoute(['study-plan/create-subject', 'id' => $model->id]), ['class' => 'btn btn-primary']); ?>

    <?= Graph::widget(['model' => $model, 'field' => '', 'readOnly' => true,
        'graph' => $model->graph, 'specialityId'=>$model->speciality_id, 'studyYearId'=>$model->study_year_id, 'studyPlan'=>false]) ?>


</div>