<?php

use app\components\Geo;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\geo\models\Country;
use app\modules\geo\models\Region;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\modules\geo\models\Smt */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="city-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'country_id')
        ->dropDownList(Country::getDropDownArray(),
            ['prompt' => Yii::t('app', 'Choose country')]);
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

    <?= $form->field($model, 'district_id')->widget(DepDrop::class, [
        'options' => ['id' => 'district_id'],
        'data' => [$model->district_id => 'default'],
        'pluginOptions'=>[
            'depends' => ['region_id'],
            'placeholder' => Yii::t('app', 'Choose district'),
            'url' => Url::to(['/geo/admin/city/district'])
        ]
    ]); ?>



    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
