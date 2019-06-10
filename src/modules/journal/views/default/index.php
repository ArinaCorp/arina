<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use app\modules\directories\models\study_year\StudyYear;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use yii\helpers\Url;
use app\modules\load\models\Load;

/* @var $this yii\web\View */
/* @var $model \app\modules\journal\models\SelectForm */

$this->title = Yii::t('app', 'Select journal page');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal-student-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>


    <div class="journal-student-form">

        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'year_id')->widget(Select2::class,
            [

                'data' => StudyYear::getYearList(),
                'pluginOptions' => [
                    'id' => 'study_year_id',
                    'placeholder' => Yii::t('app', 'Select study year'),
                ]
            ]) ?>
        <?= $form->field($model, 'speciality_qualification_id')->widget(Select2::class,
            [

                'data' => SpecialityQualification::getMap('title'),
                'pluginOptions' => [
                    'id' => 'speciality_qualification_id',
                    'placeholder' => Yii::t('app', 'Select speciality qualification'),
                ]
            ]) ?>
        <?php
        $groupData = StudyYear::getListGroupByYear($model->speciality_qualification_id, $model->year_id)
        ?>
        <?= $form->field($model, 'group_id')->widget(DepDrop::class,
            [
                'data' => $groupData,
                'pluginOptions' => [
                    'depends' => ['selectform-year_id', 'selectform-speciality_qualification_id'],
                    'url' => Url::to(['get-groups']),
                    'placeholder' => Yii::t('app', 'Select group'),
                ]
            ]) ?>
        <?php
        $loadData = Load::getListByGroupAndYear($model->group_id, $model->year_id)
        ?>
        <?= $form->field($model, 'load_id')->widget(DepDrop::class,
            [
                'data' => $loadData,
                'pluginOptions' => [
                    'depends' => ['selectform-year_id', 'selectform-group_id'],
                    'url' => Url::to(['get-loads']),
                    'placeholder' => Yii::t('app', 'Select subject from load'),
                ]]) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Selecting'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
