<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\employee\models\Employee;

/* @var $this yii\web\View */
/* @var $model app\modules\employee\models\cyclic_commission\CyclicCommission */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cyclic-commission-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'head_id')->widget(Select2::className(), [
        'data' => Employee::getAllTeacherList(),
        'options' =>
            [
                'placeholder' => Yii::t('app', 'Select head')
            ]]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
