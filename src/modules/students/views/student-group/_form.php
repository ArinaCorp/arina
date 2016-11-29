<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use app\modules\students\models\StudentGroup;
use app\modules\students\models\Student;
use app\modules\students\models\Group;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\modules\students\models\StudentGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date')->widget(dosamigos\datepicker\DatePicker::className(), [
        'language' => 'uk',
        'clientOptions' => [
            'autoclose' => true,

        ]
    ]); ?>

    <?= $form->field($model, 'group_id')->dropDownList(Group::getTreeList(),['id'=>'group-id','prompt'=>Yii::t('app','Select group'),]); ?>

    <?= $form->field($model, 'type')->dropDownList(StudentGroup::getTypesList(),['id'=>'type-id','prompt'=>Yii::t('app','Select group')]); ?>

    <?= $form->field($model, 'student_id')->widget(DepDrop::classname(), [
        'pluginOptions'=>[
            'initialize' => true,
            'depends'=>['group-id', 'type-id'],
            'placeholder'=>Yii::t('app','Select group and type action'),
            'url'=>Url::to(['getstudentslist']),
        ]
    ]); ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'funding_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
