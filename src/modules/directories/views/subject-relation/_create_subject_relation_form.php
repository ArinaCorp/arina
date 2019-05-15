<?php

use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\subject\Subject;
use app\modules\directories\models\subject_cycle\SubjectCycle;
use app\modules\directories\models\subject_relation\CreateSubjectRelationForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model CreateSubjectRelationForm */
/* @var $form ActiveForm */
?>

<div class="subject-relation-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'subject_id')->widget(Select2::class, [
                'data' => Subject::getMap('title'),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select subject')
                ]
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'subject_cycle_id')->widget(Select2::class, [
                'data' => SubjectCycle::getMap('title'),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select subject cycle')
                ]
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'speciality_qualification_ids')->widget(Select2::className(), [
                'data' => SpecialityQualification::getMap('fullTitle', 'id', [], false),
                'options' => [
                    'id' => 'items',
                    'multiple' => true,
                    'placeholder' => Yii::t('app', 'Select speciality qualifications')
                ],
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
