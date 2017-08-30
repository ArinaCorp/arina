<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalRecordTypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="journal-record-type-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'homework') ?>

    <?= $form->field($model, 'hours') ?>

    <?php // echo $form->field($model, 'present') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'n_pp') ?>

    <?php // echo $form->field($model, 'n_in_day') ?>

    <?php // echo $form->field($model, 'ticket') ?>

    <?php // echo $form->field($model, 'is_report') ?>

    <?php // echo $form->field($model, 'report_title') ?>

    <?php // echo $form->field($model, 'work_type_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
