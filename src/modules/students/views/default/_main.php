<?php
/**
 * @var \app\modules\students\models\Student $model
 */

use app\modules\geo\models\Country;
use app\modules\geo\models\Region;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\MaskedInput;

?>
<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'photo')->fileInput(); ?>
        <?= $model->getThumbFileUrl('photo', 'thumb'); ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'student_code')->widget(\yii\widgets\MaskedInput::class, ['mask' => 'AA №99999999'], ['placeholder' => $model->getAttributeLabel('birth_day')]);
        ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('last_name')]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('first_name')]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('middle_name')]) ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'gender')->dropDownList([0 => Yii::t('app', 'Male'), 1 => Yii::t('app', 'Female')], ['prompt' => Yii::t('app', 'Select gender')]); ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'birth_day')->widget(dosamigos\datepicker\DatePicker::class, [ //@TODO change to kartik-v/yii2-widget-datepicker
            'language' => 'uk',
            'clientOptions' => [
                'autoclose' => true,

            ]
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <?= $form->field($model, 'passport_code')->widget(MaskedInput::class, ['mask' => 'AA №999999']) ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'passport_issued')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('passport_issued')]) ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'passport_issued_date')->widget(dosamigos\datepicker\DatePicker::class, [ //@TODO change to kartik-v/yii2-widget-datepicker
            'language' => 'uk',
            'clientOptions' => [
                'autoclose' => true,

            ]
        ]); ?>
    </div>
    <div class="col-sm-3">
        <?= $form->field($model, 'birth_certificate')->widget(MaskedInput::class, ['mask' => 'AA №999999']);
        ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'tax_id')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'sseed_id')->textInput() ?>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-sm-8">
        <?= $form->field($model, 'finished_inst')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'finished_year')->input('number', ['class' => 'form-control no-spinner']) ?>

    </div>
</div>

<hr>

<div class="row">
    <div class="col-sm-3">
        <?= $form->field($model, 'country_id')->widget(Select2::class, [
            'data' => Country::getMap('name', 'code', [], false),
            'options' => [
                'id' => 'country-id',
                'placeholder' => Yii::t('app', 'Choose country'),
                'value' => $model->country_id ?? 'UA', // default is Ukraine
            ]]) ?>
    </div>

    <div class="col-sm-3">
        <?= $form->field($model, 'region_id')->widget(DepDrop::class, [
            'type' => DepDrop::TYPE_SELECT2,
            'data' => [$model->region_id => 'default'],
            'options' => ['id' => 'region-id'],
            'pluginOptions' => [
                'depends' => ['country-id'],
                'initialize' => true,
                'placeholder' => Yii::t('app', 'Choose region'),
                'url' => Url::to(['/geo/admin/region/get-country-regions'])
            ]
        ]); ?>
    </div>

    <div class="col-sm-3">
        <?= $form->field($model, 'city_id')->widget(DepDrop::class, [
            'type' => DepDrop::TYPE_SELECT2,
            'data' => [$model->city_id => 'default'],
            'options' => ['id' => 'city-id'],
            'pluginOptions' => [
                'depends' => ['country-id', 'region-id'],
                'placeholder' => Yii::t('app', 'Choose city'),
                'url' => Url::to(['/geo/admin/city/get-region-cities'])
            ]
        ]); ?>
    </div>

    <div class="col-sm-3">
        <?= $form->field($model, 'address')->textInput(); ?>
    </div>

</div>