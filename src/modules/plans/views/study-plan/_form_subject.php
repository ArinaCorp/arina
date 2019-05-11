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

<?php
$js = 'var semesters = ' . json_encode($model->studyPlan->semesters) . ';';

$js .= <<<JS
    function getTotalClasses() {
        var total_classes = 0;
        semesters.forEach((weeks, semester)=>{
            var hours = jQuery('#studysubject-weeks-'+semester).val();
            var sum = hours*weeks;
            total_classes = total_classes + sum;
        });
        return total_classes;
    }
    
    
    semesters.forEach((weeks, semester)=>{
        jQuery('#studysubject-weeks-'+semester).on('input', function() {
            jQuery('#total_classes').text(getTotalClasses());
        });
    });
JS;

$this->registerJs($js);
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
            <?= $form->field($model, 'subject_id')->widget(Select2::class,
                [
                    'data' => $model->isNewRecord ?
                        $model->studyPlan->getUnusedSubjects() :
                        Subject::getListForSpecialityQualification($model->studyPlan->speciality_qualification_id),
                    'options' => ['placeholder' => Yii::t('plans', 'Select subject')]
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
            <label class="control-label"
                   for="classes_week-total"><?= $model->getAttributeLabel('classes_week') ?></label>
            <?= TouchSpin::widget(['disabled' => true, 'name' => 'classes_week']) ?>
        </div>
        <div class="col-sm-3">
            <label class="control-label" for="classes-total"><?= $model->getAttributeLabel('classes') ?></label>
            <?= TouchSpin::widget(['disabled' => true, 'name' => 'classes']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'dual_lab_work')->checkbox() ?>
            <?= $form->field($model, 'dual_practice')->checkbox() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'practice_weeks')->textInput(['type' => 'number', 'min' => 0,
                'value' => $model->isNewRecord ? 0 : $model->practice_weeks,]) ?>
        </div>
    </div>

    <h3>
        <?= Yii::t('plans', 'Hours') ?>
    </h3>
    <h4>
        <?= Yii::t('plans', 'Classes') ?> <span id="total_classes"></span>
    </h4>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'total')->textInput(['type' => 'number', 'min' => 0,
                'value' => $model->isNewRecord ? 0 : $model->total,]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'lectures')->textInput(['type' => 'number', 'min' => 0,
                'value' => $model->isNewRecord ? 0 : $model->lectures,]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'lab_works')->textInput(['type' => 'number', 'min' => 0,
                'value' => $model->isNewRecord ? 0 : $model->lab_works,]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'practices')->textInput(['type' => 'number', 'min' => 0,
                'value' => $model->isNewRecord ? 0 : $model->practices,]) ?>
        </div>
    </div>

    <h3>
        <?= Yii::t('plans', 'Hours per week distribution per semester') ?>
    </h3>

    <?php foreach ($model->studyPlan->semesters as $semester => $weeks): ?>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, "weeks[$semester]")->textInput(['type' => 'number', 'min' => 0,
                    'value' => $model->isNewRecord ? 0 : $model->weeks[$semester],
                    'options' => ['placeholder' => Yii::t('plans', 'Hours per week')]])
                    ->label($semester + 1 . '-й семестр: ' . $weeks . ' тижнів') ?>
            </div>
            <div class="col-sm-1"><br/>
                <?= $form->field($model, "control[$semester][0]")->checkbox(['label' => Yii::t('plans', 'Test')]) ?>
            </div>
            <div class="col-sm-1"><br/>
                <?= $form->field($model, "control[$semester][1]")->checkbox(['label' => Yii::t('plans', 'Exam')]) ?>
            </div>
            <div class="col-sm-1"><br/>
                <?= $form->field($model, "control[$semester][2]")->checkbox(['label' => Yii::t('plans', 'DPA')]) ?>
            </div>
            <div class="col-sm-1"><br/>
                <?= $form->field($model, "control[$semester][3]")->checkbox(['label' => Yii::t('plans', 'DA')]) ?>
            </div>
            <div class="col-sm-2"><br/>
                <?= $form->field($model, "control[$semester][4]")->checkbox(['label' => Yii::t('plans', 'Course work')]) ?>
            </div>
            <div class="col-sm-2"><br/>
                <?= $form->field($model, "control[$semester][5]")->checkbox(['label' => Yii::t('plans', 'Course project')]) ?>
            </div>
        </div>
    <?php endforeach; ?>

    <?= $this->render('/_form_buttons', ['model' => $model, 'plan' => 'study']) ?>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>
</div>
