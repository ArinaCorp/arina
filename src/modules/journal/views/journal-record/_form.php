<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\employee\models\Employee;
use app\modules\plans\models\WorkSubject;

use app\modules\journal\models\record\JournalRecordType;
use kartik\date\DatePicker;
use app\modules\directories\models\audience\Audience;
use kartik\touchspin\TouchSpin;

/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalRecord */
/* @var $form yii\widgets\ActiveForm */
/* @var $type JournalRecordType */
?>

<div class="journal-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->widget(Select2::className(), [
        'data' => JournalRecordType::getList(),
        'disabled' => true,
        'readonly' => true,
    ]) ?>
    <?= $form->field($model, 'teacher_id')->widget(Select2::className(), [
        'data' => Employee::getAllTeacherList(),
    ]) ?>
    <?php if ($type->date) : ?>
        <?= $form->field($model, 'date')->widget(DatePicker::className(), [
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]) ?>
    <?php endif; ?>
    <?php if ($type->description) : ?>
        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <?php endif; ?>
    <?php if ($type->homework) : ?>
        <?= $form->field($model, 'home_work')->textarea(['rows' => 6]) ?>
    <?php endif; ?>
    <?php if ($type->n_in_day) : ?>

        <?= $form->field($model, 'number_in_day')->widget(TouchSpin::className(),
            [
                'pluginOptions' => [
                    'initval' => 1,
                    'min' => 0,
                    'max' => 8,
                    'step' => 1,
                    'decimals' => 0,
                    'boostat' => 5,
                    'maxboostedstep' => 10,
                ],
            ]) ?>
    <?php endif; ?>
    <?php if ($type->hours) : ?>
        <?= $form->field($model, 'hours')->widget(TouchSpin::className(),
            [
                'pluginOptions' => [
                    'initval' => 1,
                    'min' => 0,
                    'max' => 16,
                    'step' => 1,
                    'decimals' => 0,
                    'boostat' => 5,
                    'maxboostedstep' => 10,
                ],
            ]) ?>
    <?php endif; ?>
    <?php if ($type->audience) : ?>
        <?= $form->field($model, 'audience_id')->widget(Select2::className(), [
            'data' => Audience::getAudienceList()
        ]) ?>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
