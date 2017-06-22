<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalMark */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="journal-mark-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'record_id')->textInput() ?>

    <?= $form->field($model, 'student_id')->textInput() ?>

    <?= $form->field($model, 'presence')->textInput() ?>

    <?= $form->field($model, 'not_presence_reason_id')->textInput() ?>

    <?= $form->field($model, 'evaluation_system_id')->textInput() ?>

    <?= $form->field($model, 'evaluation_id')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'retake_evaluation_id')->textInput() ?>

    <?= $form->field($model, 'retake_date')->textInput() ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
