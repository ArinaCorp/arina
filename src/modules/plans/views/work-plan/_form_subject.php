<?php

use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\bootstrap\Html;

use app\modules\directories\models\cyclic_commission\CyclicCommission;
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
        <div class="col-sm-5">
            <?= $form->field($model, 'subject_id')->widget(Select2::className(),
                [
                    'data' => $model->isNewRecord ?
                        $model->workPlan->getUnusedSubjects() :
                        Subject::getListForSpecialityQualification($model->workPlan->speciality_qualification_id),
                    'options' =>[ 'placeholder' => Yii::t('plans', 'Select subject')]
                ]) ?>
        </div>

        <div class="col-sm-5">
            <?= $form->field($model, 'diploma_name')->textInput(['maxlength' => true,
                'placeholder' => $model->getAttributeLabel('diploma_name')]) ?>
        </div>

        <div class="col-sm-2">
            <?= $form->field($model, 'dual_practice')->checkbox(
                ['label' => $model->getAttributeLabel('dual_practice')]);?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-5">
            <?= $form->field($model, 'cyclic_commission_id')->widget(Select2::className(),
                [
                    'data' => CyclicCommission::getList(),
                    'options' =>[ 'placeholder' => Yii::t('plans', 'Select subject')]
                ]) ?>
        </div>

        <div class="col-sm-5">
            <?= $form->field($model, 'certificate_name')->textInput(['maxlength' => true,
                'placeholder' => $model->getAttributeLabel('certificate_name')]) ?>
        </div>

        <div class="col-sm-2">
            <?= $form->field($model, 'dual_lab_work')->checkbox(
                ['label' => $model->getAttributeLabel('dual_lab_work')]);?>
        </div>
    </div>
    </div>

    <?php for ($i = 0; $i < 8; $i++): ?>
        <div class="span6 semester" id="semester_<?= $i; ?>">
            <h4><?php echo $i + 1; ?> <?= Yii::t('plans', 'Semester'); ?>:
                <?= $model->workPlan->semesters[$i]; ?> <?= Yii::t('plans','Weeks');?>
                (<span class="total">0</span> <?= Yii::t('plans', 'Hours'); ?>)</h4>

            <div class="row">
                <div class="col-sm-2">
                    <?= $form->field($model, "total[$i]")->textInput(
                        ['type' => 'number', 'min' => 0, 'style' => 'width:140px',
                            'placeholder' => $model->getAttributeLabel('Total'),
                            'value' => $model->isNewRecord ? 0 : $model->total[$i]]
                    ); ?>
                </div>

                <div class="col-sm-2">
                    <label class="control-label" for="classes"><?=$model->getAttributeLabel('classes_week')?></label>
                    <?= Html::textInput(
                        "classes_$i",
                        '',
                        ['type' => 'number', 'min' => 0, 'placeholder' => Yii::t('plans','classes_week'),
                            'readonly' => true, 'style' => 'width:140px']
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
                            ['label' => $model->getAttributeLabel('test')]);?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "control[$i][1]")->checkbox(
                            ['label' => $model->getAttributeLabel('exam')]);?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "control[$i][2]")->checkbox(
                            ['label' => $model->getAttributeLabel('dpa')]);?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "control[$i][3]")->checkbox(
                            ['label' => $model->getAttributeLabel('da')]);?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "control[$i][4]")->checkbox(
                            ['label' => $model->getAttributeLabel('course_work')]);?>
                </div>

                <div class="col-sm-2">
                    <?= $form->field($model, "control[$i][5]")->checkbox(
                            ['label' => $model->getAttributeLabel('course_project')]);?>
                </div>
            </div>
                <hr/>
        </div>
    <?php endfor; ?>

    <?= $this->render('/_form_buttons', ['model' => $model, 'plan' => 'study']) ?>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>
</div>
