<?php

use app\modules\directories\models\audience\Audience;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\employee\models\Employee;

/* @var $this yii\web\View */
/* @var $model app\modules\directories\models\audience\Audience */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="audience-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">

        <div class="col-sm-3">
            <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'capacity')->textInput() ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'type')->dropDownList(Audience::getTypeList()) ?>
        </div>

    </div>


    <?= $form->field($model, 'id_teacher')->widget(Select2::className(), [
        'data' => Employee::getAllTeacherList(),
        'options' =>
            [
                'placeholder' => Yii::t('app', 'Select responsible'),
            ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
