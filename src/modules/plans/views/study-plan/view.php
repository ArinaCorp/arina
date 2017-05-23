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

$this->title = $model->specialityQualification->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Study plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <h1><?= Html::encode($this->title); ?></h1>

    <h4><?= $model->getAttributeLabel('created').': '.date('d.m.Y', $model->created); ?></h4>

    <?= Html::a(Yii::t('app', 'Export'), Url::toRoute(['study-plan/export', 'id' => $model->id]), ['class' => 'btn btn-success']); ?>

    <?= Html::a(Yii::t('app', 'Update'), Url::toRoute(['study-plan/update', 'id' => $model->id]), ['class' => 'btn btn-info']); ?>

    <?= Html::a(Yii::t('plans', 'Add subject'), Url::toRoute(['study-plan/create-subject', 'id' => $model->id]), ['class' => 'btn btn-primary']); ?>
    <br/><br/>
    <?= Graph::widget(['model' => $model, 'field' => '', 'readOnly' => true, 'graph' => $model->graph]) ?>

    <?= SubjectTable::widget(['subjectDataProvider' => $model->getStudyPlanStudySubjectProvider()]) ?>
</div>