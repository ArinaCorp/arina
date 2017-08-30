<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\geo\models\Country;

/* @var $this yii\web\View */
/* @var $model app\modules\geo\models\Region */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="region-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'country_id')
        ->dropDownList(Country::getDropDownArray(),
            ['prompt' => Yii::t('app', 'Choose country')])
        ->label(Yii::t('app', 'Country'));
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
