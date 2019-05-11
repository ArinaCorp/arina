<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\View;

use app\modules\directories\models\subject_cycle\SubjectCycle;
use app\modules\journal\models\evaluation\EvaluationSystem;


/* @var $this View */
/* @var $model SubjectCycle */
/* @var $form ActiveForm */
?>

<div class="subject-cycle-form">
    <p>
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => Yii::t('app', 'Title')]) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'evaluation_system_id')->widget(Select2::class, [
                'data' => EvaluationSystem::getMap('title'),
                'options' => [
                    'placeholder' => Yii::t('app', "Set evaluation system"),
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>