<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\directories\models\department\Department;
use kartik\select2\Select2;
use yii\web\View;

use app\modules\directories\models\subject_cycle\SubjectCycle;


/* @var $this View */
/* @var $model SubjectCycle */
/* @var $form ActiveForm */
?>

<div class="subject-cycle-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-sm-3">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
