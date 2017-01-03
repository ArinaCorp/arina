<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\web\View;
use app\modules\employee\models\Employee;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use app\modules\directories\models\position\Position;
use app\modules\directories\models\qualification\Qualification;

/* @var $this View
 * @var $model Employee
 * @var $form ActiveForm
 */

?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4">
    <?= $form->field($model, 'is_in_education')->dropDownList(
        [0 => Yii::t('app', 'Yes'), 1 => Yii::t('app', 'No')],
        ['prompt' => Yii::t('app', 'Select')]
    ); ?>
        </div>
        <div class="col-sm-3">
    <?= $form->field($model, 'position_id')->widget(Select2::className(), [
        'data' => Position::getList(),
        'options' =>
            [
                'placeholder' => Yii::t('app', 'Select position')
            ]]) ?>
        </div>
        <div class="col-sm-3">
    <?= $form->field($model, 'category_id')->widget(Select2::className(), [
        'data' => Qualification::getList(),
        'options' =>
            [
                'placeholder' => Yii::t('app', 'Select qualification')
            ]]) ?>
        </div>
        <div class="col-sm-2">
        <?= $form->field($model, 'gender')->dropDownList([0 => Yii::t('app', 'Male'), 1 => Yii::t('app', 'Female')], ['prompt' => Yii::t('app', 'Select gender')]) ?>
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
        <div class="col-sm-3">
    <?= $form->field($model, 'cyclic_commission_id')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
    <?= $form->field($model, 'birth_date')->widget(DatePicker::className(), [
        'language' => Yii::$app->language,
        'pluginOptions' => [
            'format' => 'yyyy.mm.dd',
            'autoclose' => true,
        ],
    ]); ?>
        </div>
        <div class="col-sm-3">
    <?= $form->field($model, 'passport')->widget(MaskedInput::className(), ['mask' => 'AA №999999']) ?>
        </div>
        <div class="col-sm-3">
    <?= $form->field($model, 'passport_issued_by')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('passport_issued_by')])
    //$form->field($model, 'type')->dropDownList($model->getTypes(), ['prompt' => Yii::t('app', 'Select type')])?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
