<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
use kartik\select2\Select2;
use app\modules\plans\models\WorkSubject;

/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalRecordType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="journal-record-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(SwitchInput::classname(), [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'homework')->widget(SwitchInput::classname(), [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'hours')->widget(SwitchInput::classname(), [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'present')->widget(SwitchInput::classname(), [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'date')->widget(SwitchInput::classname(), [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'n_pp')->widget(SwitchInput::classname(), [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'n_in_day')->widget(SwitchInput::classname(), [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'ticket')->widget(SwitchInput::classname(), [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'is_report')->widget(SwitchInput::classname(), [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'report_title')->textInput() ?>

    <?= $form->field($model, 'work_type_id')->widget(Select2::className(), [
        'data' => WorkSubject::getControlLabelList(),
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
