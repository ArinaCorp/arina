<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\directories\models\department\Department;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\directories\models\speciality\Speciality */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="speciality-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-sm-6">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'short_title')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-6">
            <?= $form->field($model, 'department_id')->widget(Select2::className(), [
                'data' => Department::getList(),
                'options' =>
                    [
                        'placeholder' => Yii::t('app', 'Select department')
                    ]
            ]); ?>
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'accreditation_date')->widget(dosamigos\datepicker\DatePicker::className(), [
                'language' => 'uk',
                'clientOptions' => [
                    'autoclose' => true,
                ]
            ]); ?>
        </div>
        
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
