<?php

use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\StudyYear;
use app\modules\plans\models\StudyPlan;
use app\modules\plans\models\WorkPlan;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var $this View
 * @var $model StudyPlan
 * @var ActiveForm $form
 */
?>

<div class="work-plan-form">
    <?php Pjax::begin(); ?>

    <?php $form = ActiveForm::begin(
        [
            'id' => 'dynamic-form',
            'options' => [
                'enctype' => 'multipart/form-data',
            ],

        ]
    ); ?>

    <p class="note"><?php echo Yii::t('app', 'Fields with <span class="required">*</span> are required.'); ?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'speciality_qualification_id')->widget(Select2::class, [
                'data' => SpecialityQualification::getTreeList(),
                'id' => 'speciality_qualification_id',
                'options' =>
                    [
                        'placeholder' => $model->getAttributeLabel('speciality_qualification_id')
                    ]
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'study_year_id')->widget(Select2::class, [
                'data' => StudyYear::getYearList(),
                'id' => 'study_year_id',
                'options' => [
                    'placeholder' => $model->getAttributeLabel('study_year_id')
                ]
            ]); ?>
        </div>
    </div>

    <?php if ($model->isNewRecord): ?>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'study_plan_origin')->widget(Select2::class, [
                    'data' => StudyPlan::getList(),
                    'id' => 'study_plan_origin',
                    'name' => 'study_plan_origin',
                    'options' => [
                        'placeholder' => Yii::t('plans', 'Select copy of study plan')
                    ]
                ]); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'work_plan_origin')->widget(Select2::class, [
                    'data' => WorkPlan::getList(),
                    'id' => 'work_plan_origin',
                    'name' => 'work_plan_origin',
                    'options' => [
                        'placeholder' => Yii::t('plans', 'Select copy of work plan')
                    ]
                ]); ?>
            </div>
        </div>
        <br/>
    <?php endif; ?>

    <?= $this->render('/_form_buttons', ['model' => $model, 'plan' => False]) ?>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>
</div>
