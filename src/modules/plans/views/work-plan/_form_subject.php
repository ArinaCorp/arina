<?php

use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\bootstrap\Html;

use app\modules\employee\models\CyclicCommission;
use app\modules\plans\models\WorkSubject;
use app\modules\directories\models\subject\Subject;

/**
 * @var $this View
 * @var $model WorkSubject
 * @var ActiveForm $form
 */

$jSemesters = json_encode($model->workPlan->semesters);

$js = <<<JS
//weeks in semesters, not used right now
let semesters = $jSemesters;

function showClassesForSemester(semester) {
    jQuery('#classes-' + semester).val(
        parseInt(jQuery('#worksubject-lectures-' + semester).val())
        + parseInt(jQuery('#worksubject-lab_works-' + semester).val())
        + parseInt(jQuery('#worksubject-practices-' + semester).val())
    );
}

function showSelfWorkForSemester(semester) {
    jQuery('#self_work-' + semester).val(
        parseInt(jQuery('#worksubject-total-' + semester).val()) - parseInt(jQuery('#classes-' + semester).val())
    );
}

function checkClasses(semester) {
    //total hours - distributed class hours
    let diff = parseInt(jQuery('#worksubject-total-' + semester).val()) - parseInt(jQuery('#classes-' + semester).val());
    if (diff === 0) {
        jQuery('#classes-excess-' + semester).addClass('hidden');
    } else if (diff > 0) {
        jQuery('#classes-excess-' + semester).addClass('hidden')
    } else if (diff < 0) {
        jQuery('#classes-excess-' + semester).removeClass('hidden');
        jQuery('#classes-excess-val-' + semester).text(diff);
    }
}

function calculateForSemester(semester) {
    //Order is important here, classes are used to calculate self work
    showClassesForSemester(semester);
    showSelfWorkForSemester(semester);
    checkClasses(semester);
}

//init
for (let semester = 0; semester < 8; semester++) {
    //init
    calculateForSemester(semester);

    jQuery(
        '#worksubject-weeks-' + semester
        + ', #worksubject-lectures-' + semester
        + ', #worksubject-practices-' + semester
        + ', #worksubject-lab_works-' + semester
        + ', #worksubject-total-' + semester
    ).on('input', () => calculateForSemester(semester));
}

JS;
$this->registerJs($js);


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
        <div class="col-sm-5">
            <?= $form->field($model, 'subject_id')->widget(Select2::class,
                [
                    'data' => $model->isNewRecord ?
                        $model->workPlan->getUnusedSubjects() :
                        Subject::getListForSpecialityQualification($model->workPlan->speciality_qualification_id),
                    'options' => ['placeholder' => Yii::t('plans', 'Select subject')]
                ]) ?>
        </div>

        <div class="col-sm-5">
            <?= $form->field($model, 'diploma_name')->textInput(['maxlength' => true,
                'placeholder' => $model->getAttributeLabel('diploma_name')]) ?>
        </div>

        <div class="col-sm-2">
            <?= $form->field($model, 'dual_practice')->checkbox(
                ['label' => $model->getAttributeLabel('dual_practice')]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?= $form->field($model, 'cyclic_commission_id')->widget(Select2::class,
                [
                    'data' => CyclicCommission::getMap('title'),
                    'options' => ['placeholder' => Yii::t('plans', 'Select cyclic commission')]
                ]) ?>
        </div>

        <div class="col-sm-5">
            <?= $form->field($model, 'certificate_name')->textInput(['maxlength' => true,
                'placeholder' => $model->getAttributeLabel('certificate_name')]) ?>
        </div>

        <div class="col-sm-2">
            <?= $form->field($model, 'dual_lab_work')->checkbox(
                ['label' => $model->getAttributeLabel('dual_lab_work')]); ?>
        </div>
    </div>

    <?php for ($i = 0; $i < 8; $i++): ?>
        <div class="span6 semester" id="semester_<?= $i; ?>">
            <div class="row">
                <div class="h4">
                    <div class="col-sm-3 p1"><?php echo $i + 1; ?> <?= Yii::t('plans', 'Semester'); ?>:
                        <?= $model->workPlan->semesters[$i]; ?> <?= Yii::t('plans', 'OfWeeks'); ?>
                        (<span class="total">0</span> <?= Yii::t('plans', 'OfHours'); ?>)
                    </div>
                    <div class="col-sm-9 p1 text-center" id="classes-excess-<?= $i ?>">
                        <?= Yii::t('plans', 'Excessive class hours') ?> <span id="classes-excess-val-<?= $i ?>"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2">
                    <?= $form->field($model, "total[$i]")->textInput(
                        ['type' => 'number', 'min' => 0, 'style' => 'width:140px',
                            'placeholder' => $model->getAttributeLabel('Total'),
                            'value' => $model->isNewRecord ? 0 : $model->total[$i]]
                    ); ?>
                </div>

                <div class="col-sm-1">
                    <label class="control-label" for="classes"><?= $model->getAttributeLabel('classes') ?></label>
                    <?= Html::textInput(
                        "classes-$i",
                        '',
                        ['type' => 'number', 'min' => 0, 'placeholder' => $model->getAttributeLabel('classes'),
                            'readonly' => true, 'class' => 'form-control', 'id' => "classes-$i"]
                    ); ?>
                </div>

                <div class="col-sm-1">
                    <label class="control-label" for="classes"><?= $model->getAttributeLabel('self_work') ?></label>
                    <?= Html::textInput(
                        "self_work-$i",
                        '',
                        ['type' => 'number', 'min' => 0, 'placeholder' => $model->getAttributeLabel('self_work'),
                            'readonly' => true, 'class' => 'form-control', 'id' => "self_work-$i"]
                    ); ?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "weeks[$i]")->textInput(
                        ['type' => 'number', 'min' => 0, 'style' => 'width:140px',
                            'placeholder' => $model->getAttributeLabel('weeks')]
                    ); ?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "lectures[$i]")->textInput(
                        ['type' => 'number', 'min' => 0, 'style' => 'width:140px',
                            'placeholder' => $model->getAttributeLabel('lectures')]
                    ); ?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "lab_works[$i]")->textInput(
                        ['type' => 'number', 'min' => 0, 'style' => 'width:140px',
                            'placeholder' => $model->getAttributeLabel('lab_works')]
                    ); ?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "practices[$i]")->textInput(
                        ['type' => 'number', 'min' => 0, 'style' => 'width:140px',
                            'placeholder' => $model->getAttributeLabel('practices')]
                    ); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2">
                    <?= $form->field($model, "control[$i][0]")->checkbox(
                        ['label' => $model->getAttributeLabel('test')]); ?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "control[$i][1]")->checkbox(
                        ['label' => $model->getAttributeLabel('exam')]); ?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "control[$i][2]")->checkbox(
                        ['label' => $model->getAttributeLabel('dpa')]); ?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "control[$i][3]")->checkbox(
                        ['label' => $model->getAttributeLabel('da')]); ?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "control[$i][4]")->checkbox(
                        ['label' => $model->getAttributeLabel('course_work')]); ?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "control[$i][5]")->checkbox(
                        ['label' => $model->getAttributeLabel('course_project')]); ?>
                </div>
            </div>
            <hr/>
        </div>
    <?php endfor; ?>

    <?= $this->render('/_form_buttons', ['model' => $model, 'plan' => 'study']) ?>

    <?= Html::a(Yii::t('app', 'Return'), ['work-plan/view', 'id' => $model->workPlan->id], ['class' => 'btn btn-danger']) ?>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>
</div>
