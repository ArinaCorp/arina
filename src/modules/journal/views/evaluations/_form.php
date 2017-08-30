<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\journal\models\evaluation\EvaluationSystem;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\evaluation\Evaluation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="evaluation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'system_id')->widget(Select2::className(),
        [
            'data' => EvaluationSystem::getList(),
            'options' => [
                'placeholder' => Yii::t('app', 'Select evaluation system'),
            ],
            'pluginOptions' =>
                [
                    'allowClear' => true
                ]
        ]) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
