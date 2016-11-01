<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Student */
/* @var $form \yii\bootstrap\ActiveForm */
/* @author VasyaKog */
?>

<div class="student-form">
    <?php \yii\widgets\Pjax::begin(); ?>
    <?php $form = ActiveForm::begin(
        [
            'options' => [
                'enctype' => 'multipart/form-data',
            ],
        ]
    ); ?>
    <p class="note"><?php echo Yii::t('app', 'Fields with <span class="required">*</span> are required.'); ?></p>
    <?php echo $form->errorSummary($model); ?>
    <?= $form->field($model, 'student_code')->widget(\yii\widgets\MaskedInput::className(), ['mask' => 'AA №99999999'], ['placeholder' => $model->getAttributeLabel('birth_day')]);
    ?>

    <?= $form->field($model, 'photo')->fileInput();
    ?>
    <?= $model->getThumbFileUrl('photo', 'thumb');?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('last_name')]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('first_name')]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('middle_name')]) ?>

    <?= $form->field($model, 'gender')->dropDownList([0 => Yii::t('app', 'Male'), 1 => Yii::t('app', 'Female')], ['prompt' => Yii::t('app', 'Select gender')]); ?>

    <?= $form->field($model, 'birth_day')->widget(dosamigos\datepicker\DatePicker::className(), [
        'language' => 'uk',
        'clientOptions' => [
            'autoclose' => true,

        ]
    ]); ?>

    <?= $form->field($model, 'passport_code')->widget(\yii\widgets\MaskedInput::className(), ['mask' => 'AA №999999']) ?>

    <?= $form->field($model, 'passport_issued')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('passport_issued')]) ?>

    <?= $form->field($model, 'passport_issued_date')->widget(dosamigos\datepicker\DatePicker::className(), [
        'language' => 'uk',
        'clientOptions' => [
            'autoclose' => true,

        ]
    ]); ?>

    <?= $form->field($model, 'birth_certificate')->widget(\yii\widgets\MaskedInput::className(), ['mask' => 'AA №999999']);
    ?>

    <?= $form->field($model, 'tax_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sseed_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>