<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\StudyYear;
use kartik\touchspin\TouchSpin;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Group */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'speciality_qualifications_id')->widget(Select2::className(), [
        'data' => SpecialityQualification::getTreeList(),
    ]) ?>

    <?= $form->field($model, 'created_study_year_id')->widget(Select2::className(),
        [
            'data' => StudyYear::getYearList()
        ]) ?>

    <?= $form->field($model, 'number_group')->widget(TouchSpin::className(), [
            'pluginOptions' => [
                'buttonup_class' => 'btn btn-primary',
                'buttondown_class' => 'btn btn-info',
                'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
            ],
        ]
    ) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'group_leader_id')->widget(Select2::className(),
        [
            'data' => $model->getStudentsList(),
            'pluginOptions' =>
                [
                    'placeholder' => Yii::t('app', 'Select group leader'),
                ],
        ]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
