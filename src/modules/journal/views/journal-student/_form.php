<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\journal\models\record\JournalStudent;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalStudent */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="journal-student-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->widget(Select2::className(), [
        'data' => JournalStudent::getListTypes(),
        'pluginOptions' => [
            'placeholder' => Yii::t('app', 'Select type action')
        ]
    ]); ?>
    <?php
    $studentData = [];
    if (isset($model->type)) {
        if ($model->type == JournalStudent::TYPE_ACCEPTED) {
            $studentData = JournalStudent::getAvailableStudentsList($model->load_id);
        } elseif ($model->type == JournalStudent::TYPE_DE_ACCEPTED) {
            $studentData = JournalStudent::getActiveStudentsInLoadList($model->load_id);
        }
    }
    ?>
    <?= $form->field($model, 'student_id')->widget(DepDrop::className(), [
        'data' => $studentData,
        'type' => DepDrop::TYPE_SELECT2,
        'pluginOptions' => [
            'url' => Url::toRoute(['get-students', 'load_id' => $model->load_id]),
            'depends' => ['journalstudent-type'],
            'placeholder' => Yii::t('app', 'Select student'),
        ]
    ]) ?>

    <?= $form->field($model, 'date')->widget(DatePicker::className(), [
        'pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'todayHighlight' => true,
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
