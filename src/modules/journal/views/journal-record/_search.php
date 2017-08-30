<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalRecordTypeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="journal-record-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'load_id') ?>

    <?= $form->field($model, 'teacher_id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'home_work') ?>

    <?php // echo $form->field($model, 'number') ?>

    <?php // echo $form->field($model, 'number_in_day') ?>

    <?php // echo $form->field($model, 'hours') ?>

    <?php // echo $form->field($model, 'audience_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
