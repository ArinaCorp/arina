<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\accounting\models\AccountingYear */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accounting-year-form">


    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'teacher_id')->textInput() ?>

    <?= $form->field($model, 'subject_id')->textInput() ?>

    <?= DatePicker::widget([
            'model'=>$model,
            'attribute'=>'mounth',
            'options'=>['placeHolder'=>Yii::t('app','Choose month')],
            'type'=>DatePicker::TYPE_COMPONENT_PREPEND,
            'form'=>$form,
            'pluginOptions' => [
                   'autoclose'=>true,
                    'minViewMode'=>'months',
                    'format'=> 'mm',
            ]
    ])?>

    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
