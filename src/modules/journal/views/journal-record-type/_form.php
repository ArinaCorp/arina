<?php

use app\components\exporters\marks\BaseMarkExporter;
use app\modules\plans\models\WorkSubject;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalRecordType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="journal-record-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->widget(SwitchInput::class, [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'homework')->widget(SwitchInput::class, [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>
    <?= $form->field($model, 'audience')->widget(SwitchInput::class, [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'hours')->widget(SwitchInput::class, [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'present')->widget(SwitchInput::class, [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'date')->widget(SwitchInput::class, [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'n_pp')->widget(SwitchInput::class, [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'n_in_day')->widget(SwitchInput::class, [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'ticket')->widget(SwitchInput::class, [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'is_report')->widget(SwitchInput::class, [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'has_retake')->widget(SwitchInput::class, [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]); ?>

    <?= $form->field($model, 'report_title')->dropDownList(BaseMarkExporter::getTypeTitles(), ['prompt' => '']) ?>

    <?= $form->field($model, 'work_type_id')->widget(Select2::class, [
        'data' => WorkSubject::getControlLabelList(),
        'options' => ['placeholder' => Yii::t('app', 'Select a type')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
