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

$this->title = 'View';//$model->speciality->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Study plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row well">

    <?= Html::a('Експортувати', Url::to('plans/study-plan/makeExcel', ['id' => $model->id]), ['class' => 'btn btn-primary']); ?>
    <?= Html::a('Редагувати предмети', Url::to('subjects', ['id' => $model->id]), ['class' => 'btn btn-primary']); ?>
    <br/>
    <?= Graph::widget(['model' => $model, 'field' => '', 'readOnly' => true, 'graph' => $model->graph]) ?>
