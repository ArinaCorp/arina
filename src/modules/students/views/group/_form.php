<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'speciality_qualifications_id')->dropDownList(\app\modules\directories\models\speciality_qualification\SpecialityQualification::getTreeList()) ?>

    <?= $form->field($model, 'created_study_year_id')->dropDownList(\app\modules\directories\models\StudyYear::getYearList()) ?>

    <?= $form->field($model, 'number_group')->widget(\kartik\touchspin\TouchSpin::className(), [
            'pluginOptions' => [
                'buttonup_class' => 'btn btn-primary',
                'buttondown_class' => 'btn btn-info',
                'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
            ],
        ]
    ) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'group_leader_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
