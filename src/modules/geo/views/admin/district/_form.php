<?php

use app\modules\geo\models\Country;
use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\geo\models\District */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="country-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'country_id')
        ->dropDownList(Country::getDropDownArray(),
            ['prompt' => Yii::t('app', 'Choose country')])
        ->label(Yii::t('app', 'Country'));
    ?>

    <?= $form->field($model, 'region_id')->widget(DepDrop::class, [
        'options' => ['id' => 'region_id'],
        'data' => [$model->region_id => 'default'],
        'pluginOptions'=>[
            'depends' => [Html::getInputId($model,'country_id')],
            'initialize' => true,
            'placeholder' => Yii::t('app', 'Choose region'),
            'url' => Url::to(['/geo/admin/city/region'])
        ]
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
