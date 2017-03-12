<?php

use yii\bootstrap\Html;
use yii\web\View;
use yii\helpers\Url;

use app\modules\plans\models\StudyPlan;
use app\modules\plans\widgets\Graph;
use app\modules\plans\widgets\SubjectTable;
/**
 * @var $this View
 * @var $model StudyPlan
 */

$this->title = $model->speciality->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Study plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <h1><?= $model->speciality->title; ?></h1>

    <h4><?= $model->getAttributeLabel('created').': '.$model->created; ?></h4>

    <?= Html::a(Yii::t('plans', 'Export'), Url::toRoute(['study-plan/make-excel', 'id' => $model->id]), ['class' => 'btn btn-success']); ?>

    <?= Html::a(Yii::t('plans', 'Update'), Url::toRoute(['study-plan/update', 'id' => $model->id]), ['class' => 'btn btn-info']); ?>

    <?= Html::a(Yii::t('plans', 'Add subject'), Url::toRoute(['study-plan/create-subject', 'id' => $model->id]), ['class' => 'btn btn-primary']); ?>
    <br/><br/>
    <?= Graph::widget(['model' => $model, 'field' => '', 'readOnly' => true, 'graph' => $model->graph]) ?>

    <?= SubjectTable::widget(['subjectDataProvider' => $model->getStudyPlanStudySubjectProvider()]) ?>
</div>