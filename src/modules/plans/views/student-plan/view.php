<?php

use app\modules\plans\models\StudentPlan;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
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

/** @var User $user */
$user = Yii::$app->user->identity;
?>

<div class="row">

    <div class="col-lg-12">
        <h2><?= Html::encode($this->title) ?></h2>
        <h3><?= Html::encode(Yii::t('app', 'Study year') . ' ' . $model->workPlan->getYearTitle()) ?></h3>
        <h4><?= Html::encode(Yii::t('app', 'Semester') . ': ' . $model->semester) ?></h4>
        <h4><?= Html::encode(Yii::t('app', 'Student') . ': ' . $model->student->fullName . ' (' . $model->group->title . ')'); ?></h4>
        <h4><?= Html::encode(Yii::t('app', 'Department') . ': ' . $model->workPlan->specialityQualification->speciality->department->title); ?></h4>
        <h4><?= Html::encode(Yii::t('app', 'Speciality') . '/' . Yii::t('app', 'Education program') . ': ' . $model->workPlan->specialityQualification->speciality->title); ?></h4>
        <!-- TODO: implement study form -->
        <h4><?= Html::encode(Yii::t('app', 'Study form') . ': ' . 'денна'); ?></h4>
    </div>

    <div class="col-lg-12">
        <?php
        echo Html::a(Yii::t('app', 'Export'), Url::toRoute(['/plans/student-plan/export', 'id' => $model->id]), [
            'class' => 'btn btn-success',
            'target' => '_blank',
            'data-pjax' => "0",
        ]);
        if ((!$model->isApproved() && UserHelper::isStudent($user)) || !UserHelper::isStudent($user)) {
            echo Html::a(Yii::t('app', 'Update'), Url::toRoute(['/plans/student-plan/update', 'id' => $model->id]), ['class' => 'btn btn-info mx-1']);
        }
        if (!UserHelper::isStudent($user)) {
            echo Html::a(Yii::t('app', 'Delete'), Url::toRoute(['/plans/student-plan/delete', 'id' => $model->id]), ['class' => 'btn btn-danger']);
        }
        ?>
    </div>

    <div class="col-lg-12">
        <?php
        if ($model->isApproved()): ?>
            <h4><?= Html::encode(Yii::t('app', 'Plan is approved by {fullName}', ['fullName' => $model->getApproverFullName()])); ?></h4>
            <?php if (!UserHelper::isStudent($user)): ?>
                <?= Html::a(Yii::t('app', 'Disapprove'), Url::toRoute(['/plans/student-plan/disapprove', 'id' => $model->id]), ['class' => 'btn btn-danger',]); ?>
            <?php endif; ?>
        <?php else: ?>
            <h4><?= Html::encode(Yii::t('app', 'Plan is not approved yet')); ?></h4>
            <?php if (!UserHelper::isStudent($user)): ?>
                <?= Html::a(Yii::t('app', 'Approve'), Url::toRoute(['/plans/student-plan/approve', 'id' => $model->id]), ['class' => 'btn btn-success']); ?>
            <?php endif;
        endif;
        ?>
    </div>


    <div class="m1 col-lg-12">
        <?= $this->render('_subjects', ['model' => $model]); ?>
    </div>

    <div class="col-lg-12">
        <h5><?= Html::encode(Yii::t('app', 'Created At') . ' ' . Yii::$app->formatter->asDate($model->created, 'dd.mm.y')); ?></h5>
        <?php if ($model->updated): ?>
            <h5><?= Html::encode(Yii::t('app', 'Updated At') . ' ' . Yii::$app->formatter->asDate($model->updated, 'dd.mm.y')); ?></h5>
        <?php endif; ?>
        <h4><?= Html::encode(Yii::t('app', 'Group curator') . ' ' . $model->group->getCuratorFullName()); ?></h4>
    </div>
</div>