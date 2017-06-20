<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\journal\models\record\JournalStudent;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalStudent */
/* @var $form yii\widgets\ActiveForm */
var_dump(Url::toRoute(['get-students', 'load_id' => $model->load_id]));
?>

<div class="journal-student-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->widget(Select2::className(), [
        'data' => JournalStudent::getListTypes(),
        'pluginOptions' => [
            'placeholder' => Yii::t('app', 'Select type action')
        ]
    ]); ?>

    <?= $form->field($model, 'student_id')->widget(DepDrop::className(), [
        'pluginOptions' => [
            'url' => Url::toRoute(['get-students', 'load_id' => $model->load_id]),
            'depends' => ['journalstudent-type'],
            'placeholder' => Yii::t('app', 'Select student'),
        ]
    ]) ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
