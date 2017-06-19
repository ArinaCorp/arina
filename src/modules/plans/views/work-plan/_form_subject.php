<?php

use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\bootstrap\Html;

use app\modules\plans\models\WorkSubject;
use app\modules\directories\models\subject\Subject;

/**
 * @var $this View
 * @var $model WorkSubject
 * @var ActiveForm $form
 */

?>

<div class="work-subject-form">
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
                    'data' => $model->isNewRecord ?
                        $model->workPlan->getUnusedSubjects() :
                        Subject::getListForSpecialityQualification($model->studyPlan->speciality_qualification_id),
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

    <?php for ($i = 0; $i < 8; $i++): ?>
        <div class="span6 semester" id="semester_<?= $i; ?>">
            <h4><?php echo $i + 1; ?>-й семестр:
                <?= $model->workPlan->semesters[$i]; ?> <?= Yii::t('plans','Weeks');?>
                (<span class="total">0</span> год.)</h4>

            <div class="row">
                <div class="col-sm-2">
                    <?= $form->field($model, "total[$i]")->textInput(
                        ['type' => 'number', 'min' => 0, 'style' => 'width:140px',
                            'placeholder' => $model->getAttributeLabel('Total')]
                    ); ?>
                </div>

                <div class="col-sm-2">
                    <label class="control-label" for="classes"><?=$model->getAttributeLabel('classes_week')?></label>
                    <?= Html::textInput(
                        "classes_$i",
                        '',
                        ['type' => 'number', 'min' => 0, 'placeholder' => 'Аудиторні', 'readonly' => true, 'style' => 'width:140px']
                    ); ?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "weeks[$i]")->textInput(
                        ['type' => 'number', 'min' => 0, 'style' => 'width:140px',
                            'placeholder' => $model->getAttributeLabel('Weeks')]
                    ); ?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "lectures[$i]")->textInput(
                        ['type' => 'number', 'min' => 0, 'style' => 'width:140px',
                            'placeholder' => $model->getAttributeLabel('Lectures')]
                    ); ?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "lab_works[$i]")->textInput(
                        ['type' => 'number', 'min' => 0, 'style' => 'width:140px',
                            'placeholder' => $model->getAttributeLabel('Laboratory works')]
                    ); ?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "practices[$i]")->textInput(
                        ['type' => 'number', 'min' => 0, 'style' => 'width:140px',
                            'placeholder' => $model->getAttributeLabel('Practices')]
                    ); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2">
                    <?= $form->field($model, "control[$i][0]")->checkbox(
                            ['label' => $model->getAttributeLabel('Test')]);?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "control[$i][1]")->checkbox(
                            ['label' => $model->getAttributeLabel('Exam')]);?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "control[$i][2]")->checkbox(
                            ['label' => $model->getAttributeLabel('DPA')]);?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "control[$i][3]")->checkbox(
                            ['label' => $model->getAttributeLabel('DA')]);?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "control[$i][4]")->checkbox(
                            ['label' => $model->getAttributeLabel('Course work')]);?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "control[$i][5]")->checkbox(
                            ['label' => $model->getAttributeLabel('Course project')]);?>
                </div>
            </div>
                <hr/>
        </div>
    <?php endfor; ?>

    <?= $this->render('/_form_buttons', ['model' => $model, 'plan' => 'study']) ?>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>
</div>
