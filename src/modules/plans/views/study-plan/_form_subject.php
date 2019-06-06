<?php

use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use kartik\touchspin\TouchSpin;

use app\modules\plans\models\StudySubject;
use app\modules\directories\models\subject_relation\SubjectRelation;

/**
 * @var $this View
 * @var $model StudySubject
 * @var ActiveForm $form
 */
?>

<?php
$jSemesters = json_encode($model->studyPlan->semesters);

$js = <<<JS
let semesters = $jSemesters;

function getTotalClasses() {
    var total_classes = 0;
    semesters.forEach((weeks, semester) => {
        var hours = parseInt(jQuery('#studysubject-weeks-' + semester).val());
        var sum = hours * weeks;
        total_classes += sum;
    });
    return total_classes;
}

//init
jQuery('#classes-total-val').text(getTotalClasses());

semesters.forEach((weeks, semester) => {
    //init
    showHoursForSemester(semester, weeks);

    jQuery('#studysubject-weeks-' + semester).on('input', function () {
        showHoursForSemester(semester, weeks);
        jQuery('#classes-total-val').text(getTotalClasses());
        checkClasses();
    });
});

function getDistributedClasses() {
    return [...jQuery('#studysubject-lectures, #studysubject-lab_works, #studysubject-practices').map(function () {
        return parseInt($(this).val());
    })].reduce((partSum, a) => partSum + a, 0);
}

function checkClasses() {
    let diff = parseInt(getTotalClasses() - getDistributedClasses());
    if (diff === 0) {
        jQuery('#classes-left').addClass('hidden');
        jQuery('#classes-excess').addClass('hidden');
    } else if (diff > 0) {
        jQuery('#classes-left').removeClass('hidden');
        jQuery('#classes-left-val').text(diff);
        jQuery('#classes-excess').addClass('hidden')
    } else if (diff < 0) {
        jQuery('#classes-excess').removeClass('hidden');
        jQuery('#classes-excess-val').text(diff);
        jQuery('#classes-left').addClass('hidden')
    }
}

//init
checkClasses();

jQuery('#studysubject-lectures, #studysubject-lab_works, #studysubject-practices').on('input', () => checkClasses());

function showHoursForSemester(semester, weeks) {
    let hours = parseInt(jQuery('#studysubject-weeks-' + semester).val());
    jQuery('#semester-' + semester + '-classes-val').text(hours * weeks);
}


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
        <div class="col-sm-5">
            <?= $form->field($model, 'subjectRelationId')->widget(Select2::class,
                [
                    'data' => SubjectRelation::getListByStudyPlanId($model->study_plan_id, $model->subjectRelationId),
                    'options' => ['placeholder' => Yii::t('plans', 'Select subject')]
                ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'diploma_name')->textInput(['maxlength' => true,
                'placeholder' => $model->getAttributeLabel('diploma_name')]) ?>
        </div>
        <div class="col-sm-6">
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
            <label class="control-label" for="classes"><?= $model->getAttributeLabel('classes') ?></label>
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

    <div class="row">
        <div class="col-sm-12">
            <h4 class="text-center">
                <div class="col-sm-3 p1">
                    <?= Yii::t('plans', 'Classes') ?> <span id="classes-total-val"></span>
                </div>
                <div class="col-sm-9 p1">
                    <div id="classes-left">
                        <?= Yii::t('plans', 'Class hours left to distribute') ?> <span id="classes-left-val"></span>
                    </div>
                    <div id="classes-excess">
                        <?= Yii::t('plans', 'Excessive class hours') ?> <span id="classes-excess-val"></span>
                    </div>
                </div>
            </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'total')->textInput(['type' => 'number', 'min' => 0,
                'value' => $model->isNewRecord ? 0 : $model->total]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'lectures')->textInput(['type' => 'number', 'min' => 0,
                'value' => $model->isNewRecord ? 0 : $model->lectures]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'lab_works')->textInput(['type' => 'number', 'min' => 0,
                'value' => $model->isNewRecord ? 0 : $model->lab_works]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'practices')->textInput(['type' => 'number', 'min' => 0,
                'value' => $model->isNewRecord ? 0 : $model->practices]) ?>
        </div>
    </div>

    <h3>
        <?= Yii::t('plans', 'Hours per week distribution per semester') ?>
    </h3>

    <?php foreach ($model->studyPlan->semesters as $semester => $weeks): ?>
        <div class="row">
            <div class="col-sm-3">
                <b class="pull-right">
                    <span id="semester-<?= $semester ?>-classes-val"></span> <?= Yii::t('plans', 'hrs.') ?>
                </b>
                <?= $form->field($model, "weeks[$semester]")->textInput(['type' => 'number', 'min' => 0,
                    'value' => $model->isNewRecord ? 0 : $model->weeks[$semester],
                    'options' => ['placeholder' => Yii::t('plans', 'Hours per week')]])
                    ->label($semester + 1 . '-й семестр: ' . $weeks . ' тижнів') ?>
            </div>
            <div class="col-sm-1">

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
