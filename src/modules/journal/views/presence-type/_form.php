<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;
use kartik\touchspin\TouchSpin;

/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\presence\NotPresenceType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="not-presence-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_great')->widget(SwitchInput::classname(), [
        'pluginOptions' =>
            [
                'onText' => Yii::t('app', 'Yes'),
                'offText' => Yii::t('app', 'No'),
            ]
    ]);
    ?>

    <?= $form->field($model, 'percent_hours')->widget(TouchSpin::className(),
        [
            'pluginOptions' => [
                'initval' => 100,
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'decimals' => 0,
                'boostat' => 5,
                'maxboostedstep' => 10,
            ],
        ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
