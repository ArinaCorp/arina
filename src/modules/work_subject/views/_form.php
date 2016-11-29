<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\modules\directories\models\subject\Subject;

/* @var $this View
 * @var $model Subject
 * @var $form ActiveForm */
/**
 * @property integer $id
 * @property integer $subject_id
 * @property integer $plan_id
 * @property array $total
 * @property array $lectures
 * @property array $labs
 * @property array $practices
 * @property array $weeks
 * @property array $control
 * @property integer $cyclic_commission_id
 * @property string $certificate_name
 * @property string $diploma_name
 * @property integer $project_hours
 * @property array $control_hours
 * @property bool $dual_labs
 * @property bool $dual_practice */

?>

<div class="subject-form">



    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'practice')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
