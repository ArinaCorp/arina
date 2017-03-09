<?php

use yii\helpers\Html;
use yii\widgets\MaskedInput;
use yii\web\View;
use app\modules\employee\models\Employee;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use app\modules\directories\models\position\Position;
use app\modules\directories\models\qualification\Qualification;
use app\modules\employee\models\cyclic_commission\CyclicCommission;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this View
 * @var $model Employee
 * @var $form \yii\widgets\ActiveForm
 * @var $modelsEducation \app\modules\employee\models\EmployeeEducation[]
 */

$js = '
jQuery(".dynamicform_education").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_education .panel-title-address").each(function(index) {
        jQuery(this).html("' . Yii::t('app', 'Education') . ': " + (index + 1))
    });
});

jQuery(".dynamicform_education").on("afterDelete", function(e) {
    jQuery(".dynamicform_education .panel-title-address").each(function(index) {
        jQuery(this).html("' . Yii::t('app', 'Education') . ': " + (index + 1))
    });
});
';

$this->registerJs($js);
?>

<div class="employee-form">

    <?php \yii\widgets\Pjax::begin(); ?>
    <?php $form = ActiveForm::begin(
        [
            'id' => 'employee-form',
            'options' => [
                'enctype' => 'multipart/form-data',
            ],

        ]
    ); ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'is_in_education')
                ->dropDownList(
                    [0 => Yii::t('app', 'No'), 1 => Yii::t('app', 'Yes')],
                    ['prompt' => Yii::t('app', 'Select option')]
                ) ?>
        </div>
        <div class="col-sm-4 hidden field_cyclic_commission_id">
            <?= $form->field($model, 'cyclic_commission_id')->widget(Select2::className(), [
                'data' => CyclicCommission::getList(),
                'options' =>
                    [
                        'placeholder' => Yii::t('app', 'Select cyclic commission')
                    ]]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'start_date')->widget(DatePicker::className(), [
                'language' => Yii::$app->language,
                'pluginOptions' => [
                    'format' => 'yyyy.mm.dd',
                    'autoclose' => true,
                ],
            ]); ?>
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

    <br>

    <div class="row">
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
        <div class="col-sm-3">
        <?= $form->field($model, 'gender')->dropDownList([0 => Yii::t('app', 'Male'), 1 => Yii::t('app', 'Female')], ['prompt' => Yii::t('app', 'Select gender')]) ?>
        </div>
    </div>

    <br>

    <div class="row">

        <div class="col-sm-3">
    <?= $form->field($model, 'passport')->widget(MaskedInput::className(), ['mask' => 'AA №999999']) ?>
        </div>
        <div class="col-sm-3">
    <?= $form->field($model, 'passport_issued_by')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('passport_issued_by')])
    //$form->field($model, 'type')->dropDownList($model->getTypes(), ['prompt' => Yii::t('app', 'Select type')])?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'passport_issued_date')->widget(DatePicker::className(), [
                'language' => Yii::$app->language,
                'pluginOptions' => [
                    'format' => 'yyyy.mm.dd',
                    'autoclose' => true,
                ],
            ]); ?>
        </div>
    </div>

    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_education', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 12, // the maximum times, an element can be cloned (default 999)
        'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsEducation[0],
        'formId' => 'employee-form',
        'formFields' => [
            'name_of_institution',
            'document',
            'graduation_year',
            'speciality',
            'qualification',
            'education_form',
        ],
    ]); ?>
    <div class="panel panel-default education">
        <div class="panel-heading">
            <i class="fa fa-users"></i> <?= Yii::t('app', 'Education') ?>
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i
                    class="fa fa-plus"></i> <?= Yii::t('app', 'Add education') ?></button>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items"><!-- widgetContainer -->
            <?php foreach ($modelsEducation as $index => $modelEducation): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                            <span class="panel-title-address"><?= Yii::t('app', 'Education') ?>
                                : <?= ($index + 1) ?></span>
                        <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i
                                class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        // necessary for update action.
                        if (!$modelEducation->isNewRecord) {
                            echo Html::activeHiddenInput($modelEducation, "[{$index}]id");
                        }
                        ?>

                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($modelEducation, "[{$index}]name_of_institution")->textInput() ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelEducation, "[{$index}]document")->textInput() ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelEducation, "[{$index}]graduation_year")->textInput() ?>
                            </div>
                        </div><!-- end:row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelEducation, "[{$index}]speciality")->textInput() ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelEducation, "[{$index}]qualification")->textInput() ?>
                            </div>
                        </div><!-- end:row -->

                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($modelEducation, "[{$index}]education_form")->widget(MaskedInput::className(), ['mask' => '(999) 999-9999']); ?>
                            </div>
                            </div>
                        </div><!-- end:row -->
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php DynamicFormWidget::end(); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
