<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\journal\models\record\JournalRecordType;

/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalRecordFirst */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="journal-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->widget(Select2::class, [
        'data' => JournalRecordType::getMap('title'),
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
