<?php

use nullref\admin\models\Admin;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$module = Yii::$app->getModule('admin');
/* @var $this yii\web\View */
/* @var $model nullref\admin\models\Admin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'firstName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?php if (Yii::$app->getModule('admin')->enableRbac): ?>
        <?= $form->field($model, 'role')->dropDownList(Yii::$app->getModule('admin')->get('roleContainer')->getTitles()) ?>
    <?php endif ?>

    <?= $form->field($model, 'status')->dropDownList(Admin::getStatuses()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('admin', 'Create') : Yii::t('admin', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
