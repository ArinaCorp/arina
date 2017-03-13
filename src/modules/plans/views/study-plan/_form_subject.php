<?php

use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use kartik\touchspin\TouchSpin;

use app\modules\plans\models\StudySubject;
use app\modules\directories\models\subject\Subject;

/**
 * @var $this View
 * @var $model StudySubject
 * @var ActiveForm $form
 */
?>

<div class="study-subject-form">
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
        <div class="col-sm-4">
            <?= $form->field($model, 'subject_id')->widget(Select2::className(),
                [
                    'data' => $model->isNewRecord ? $model->studyPlan->getUnusedSubjects() : Subject::getListForSpeciality($model->studyPlan->speciality_id),
                    'options' =>[ 'placeholder' => Yii::t('plans', 'Select subject')]
                ]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'diploma_name')->textInput(['maxlength' => true,
                'placeholder' => $model->getAttributeLabel('diploma_name')]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'certificate_name')->textInput(['maxlength' => true,
                'placeholder' => $model->getAttributeLabel('certificate_name')]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'total')->widget(TouchSpin::className(), ['pluginOptions' => ['max'=>1000]])?>
        </div>
        <div class="col-sm-3">
            <label class="control-label" for="classesweek-total"><?=$model->getAttributeLabel('classes_week')?></label>
            <?= TouchSpin::widget(['disabled' => true, 'name' => 'classes_week'])?>
        </div>
        <div class="col-sm-3">
            <label class="control-label" for="classes-total"><?=$model->getAttributeLabel('classes')?></label>
            <?= TouchSpin::widget(['disabled' => true, 'name' => 'classes'])?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'lectures')->widget(TouchSpin::className(), ['pluginOptions' => ['max'=>1000]])?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'lab_works')->widget(TouchSpin::className(), ['pluginOptions' => ['max'=>1000]])?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'practices')->widget(TouchSpin::className(), ['pluginOptions' => ['max'=>1000]])?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'dual_lab_work')->checkbox()?>
            <?= $form->field($model, 'dual_practice')->checkbox()?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'practice_weeks')->widget(TouchSpin::className(), ['pluginOptions' => ['max'=>1000]])?>
        </div>
    </div>
    <?php foreach ($model->studyPlan->semesters as $semester => $weeks): ?>
        <div class="row">
            <div class="col-sm-4">
                <label class="control-label"><?= $semester + 1 . '-й семестр: ' . $weeks . ' тижнів'?></label>
                <?= $form->field($model, "weeks[$semester]")->widget(TouchSpin::className(),
                    ['pluginOptions' => ['max'=>1000]])?>
            </div>
            <div class="col-sm-1">
                <?= $form->field($model, "control[$semester][0]")->checkbox(['label' => Yii::t('plans', 'Test')])?>
            </div>
            <div class="col-sm-1">
                <?= $form->field($model, "control[$semester][1]")->checkbox(['label' => Yii::t('plans', 'Exam')])?>
            </div>
            <div class="col-sm-1">
                <?= $form->field($model, "control[$semester][2]")->checkbox(['label' => Yii::t('plans', 'DPA')])?>
            </div>
            <div class="col-sm-1">
                <?= $form->field($model, "control[$semester][3]")->checkbox(['label' => Yii::t('plans', 'DA')])?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, "control[$semester][4]")->checkbox(['label' => Yii::t('plans', 'Course work')])?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, "control[$semester][5]")->checkbox(['label' => Yii::t('plans', 'Course project')])?>
            </div>
        </div>
    <?php endforeach; ?>

    <?= $this->render('_form_buttons', ['model' => $model, ]) ?>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>
</div>