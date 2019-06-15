<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\directories\models\study_year\StudyYear;
use app\modules\employee\models\Employee;

/* @var $this yii\web\View */
/* @var $model app\modules\accounting\models\YearlyHourAccounting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="yearly-hour-accounting-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'study_year_id')->widget(Select2::class, [
        'data' => StudyYear::getMap('title', 'id', [], false)
    ]) ?>

    <?= $form->field($model, 'teacher_id')->widget(Select2::class, [
        'data' => Employee::getMap('fullName', 'id', [], false)
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
