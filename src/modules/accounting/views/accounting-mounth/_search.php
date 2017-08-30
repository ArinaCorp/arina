<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\accounting\models\AccountingMounthSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accounting-mounth-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'acc_id') ?>

    <?= $form->field($model, 'group_id') ?>

    <?= $form->field($model, 'subject_id') ?>

    <?= $form->field($model, 'teacher_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
