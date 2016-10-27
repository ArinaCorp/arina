<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\touchspin\TouchSpin;

/* @var $this yii\web\View */
/* @var $model app\modules\directories\models\speciality_qualification\SpecialityQualification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="speciality-qualification-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'years_count')->widget(TouchSpin::className(), [
        'pluginOptions' => [
            'buttonup_class' => 'btn btn-primary',
            'buttondown_class' => 'btn btn-info',
            'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
            'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
        ]
    ]) ?>

    <?= $form->field($model, 'months_count')->widget(TouchSpin::className(), [
        'pluginOptions' => [
            'buttonup_class' => 'btn btn-primary',
            'buttondown_class' => 'btn btn-info',
            'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
            'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>',
            'max' => 11,
        ]
    ]) ?>

    <?= $form->field($model,'qualification_id')->dropDownList(\app\modules\directories\models\qualification\Qualification::getList());?>

    <?= $form->field($model, 'speciality_id')->dropDownList(\app\modules\directories\models\speciality_qualification\SpecialityQualification::getTreeList());?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
