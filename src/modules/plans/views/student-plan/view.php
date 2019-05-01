<?php

use app\modules\plans\models\StudentPlan;
use kartik\select2\Select2;
use yii\bootstrap\Html;
use yii\web\View;
use yii\helpers\Url;

use app\modules\plans\models\WorkPlan;
use app\modules\plans\widgets\Graph;
use yii\widgets\Pjax;

/**
 * @var $this View
 * @var $model StudentPlan
 */

$this->title = Yii::t('plans', 'Student plan');

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Student plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <h2><?= Html::encode($this->title) ?></h2>
    <h3><?= Html::encode(Yii::t('app', 'Study year') . ' ' . $model->workPlan->getYearTitle()) ?></h3>
    <h4>Семестр: 1</h4>
    <h4><?= Html::encode(Yii::t('app', 'Student') . ': ' . $model->student->fullName . ' (' . $model->student->groups[0]->title . ')'); ?></h4>
    <h4><?= Html::encode(Yii::t('app', 'Department') . ': ' . $model->workPlan->specialityQualification->speciality->department->title); ?></h4>
    <h4><?= Html::encode(Yii::t('app', 'Speciality') . '/' . Yii::t('app', 'Education program') . ': ' . $model->workPlan->specialityQualification->speciality->title); ?></h4>
    <h4><?= Html::encode(Yii::t('app', 'Study form') . ': ' . 'денна'); ?></h4>

    <?= Html::a(Yii::t('app', 'Export'), Url::toRoute(['student-plan/export', 'id' => $model->id]), ['class' => 'btn btn-success']); ?>

    <?= Html::a(Yii::t('app', 'Update'), Url::toRoute(['student-plan/update', 'id' => $model->id]), ['class' => 'btn btn-info']); ?>

    <?= Html::a(Yii::t('app', 'Delete'), Url::toRoute(['student-plan/delete', 'id' => $model->id]), ['class' => 'btn btn-danger']); ?>

    <br/><br/>

    <?php Pjax::begin(); ?>
    <?= $this->render('_subjects', ['model' => $model]); ?>
    <?php Pjax::end(); ?>

    <h5><?= Html::encode(Yii::t('app', 'Created At') . ' ' . Yii::$app->formatter->asDate($model->created, 'dd.mm.y')); ?></h5>

    <h4><?= Html::encode(Yii::t('app', 'Group curator') . ' ' . $model->student->groups[0]->getCuratorFullName()); ?></h4>

</div>