<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\directories\models\department\Department;
use kartik\select2\Select2;
use yii\web\View;
use yii\widgets\Pjax;

use app\modules\directories\models\subject_relation\SubjectRelation;
use app\modules\directories\models\subject\Subject;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\subject_cycle\SubjectCycle;

/* @var $this View */
/* @var $model SubjectRelation */
/* @var $form ActiveForm */
?>

<div class="subject-relation-form">
    <?php Pjax::begin(); ?>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-sm-6">
            <?= $form->field($model, 'subject_id')->widget(Select2::className(), [
                'data' => Subject::getList(),
                'options' =>
                    [
                        'placeholder' => Yii::t('app', 'Select subject')
                    ]
            ]); ?>
        </div>

    </div>

    <div class="row">

        <div class="col-sm-6">
            <?= $form->field($model, 'subject_cycle_id')->widget(Select2::className(), [
                'data' => SubjectCycle::getList(),
                'options' =>
                    [
                        'placeholder' => Yii::t('app', 'Select subject cycle')
                    ]
            ]); ?>
        </div>

    </div>

    <div class="row">

        <div class="col-sm-6">
            <?= $form->field($model, 'speciality_qualification_id')->widget(Select2::className(), [
                'data' => SpecialityQualification::getList(),
                'options' =>
                    [
                        'placeholder' => Yii::t('app', 'Select department')
                    ]
            ]); ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>
</div>
