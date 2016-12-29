<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\touchspin\TouchSpin;
use kartik\select2\Select2;
use app\modules\directories\models\qualification\Qualification;
use app\modules\directories\models\speciality\Speciality;

/* @var $this yii\web\View */
/* @var $model app\modules\directories\models\specialityqualification\SpecialityQualification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="speciality-qualification-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-sm-4">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-4">
            <?= $form->field($model, 'qualification_id')->widget(Select2::className(),
                [
                    'data' => Qualification::getList(),
                    'options' =>
                        [
                            'placeholder' => Yii::t('app', 'Select qualification'),
                        ]
                ]); ?>
        </div>

        <div class="col-sm-4">
            <?= $form->field($model, 'speciality_id')->widget(Select2::className(),
                [
                    'data' => Speciality::getSpecialityTreeList(),
                    'options' =>
                        [
                            'placeholder' => Yii::t('app', 'Select speciality'),
                        ]
                ]); ?>
        </div>

    </div>

    <div class="row">

        <div class="col-sm-6">
            <?= $form->field($model, 'years_count')->widget(TouchSpin::className(), [
                'pluginOptions' => [
                    'buttonup_class' => 'btn btn-primary',
                    'buttondown_class' => 'btn btn-info',
                    'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                    'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>'
                ]
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'months_count')->widget(TouchSpin::className(), [
                'pluginOptions' => [
                    'buttonup_class' => 'btn btn-primary',
                    'buttondown_class' => 'btn btn-info',
                    'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                    'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>',
                    'max' => 11,
                ]
            ]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
