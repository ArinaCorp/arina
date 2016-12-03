<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\modules\employee\models\Employee;

/* @var $this View
 * @var $model Employee
 * @var $form ActiveForm
 */

?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'is_in_education')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cyclic_commission_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birth_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passport')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'passport_issued_by')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
