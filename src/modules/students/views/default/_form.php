<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\modules\students\models\FamilyTiesType;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Student */
/* @var $modelsFamily \app\modules\students\models\FamilyTie[] */
/* @var $form \yii\bootstrap\ActiveForm */
/* @author VasyaKog */

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("' . Yii::t('app', 'Family tie') . ': " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("' . Yii::t('app', 'Family tie') . ': " + (index + 1))
    });
});
';

$this->registerJs($js);
?>


<div class="student-form">
    <?php \yii\widgets\Pjax::begin(); ?>
    <?php $form = ActiveForm::begin(
        [
            'id' => 'dynamic-form',
            'options' => [
                'enctype' => 'multipart/form-data',
            ],

        ]
    ); ?>
    <p class="note"><?php echo Yii::t('app', 'Fields with <span class="required">*</span> are required.'); ?></p>
    <?php echo $form->errorSummary($model); ?>
    <?= $form->field($model, 'student_code')->widget(\yii\widgets\MaskedInput::className(), ['mask' => 'AA №99999999'], ['placeholder' => $model->getAttributeLabel('birth_day')]);
    ?>

    <?= $form->field($model, 'photo')->fileInput();
    ?>
    <?= $model->getThumbFileUrl('photo', 'thumb'); ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('last_name')]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('first_name')]) ?>

    <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('middle_name')]) ?>

    <?= $form->field($model, 'gender')->dropDownList([0 => Yii::t('app', 'Male'), 1 => Yii::t('app', 'Female')], ['prompt' => Yii::t('app', 'Select gender')]); ?>

    <?= $form->field($model, 'birth_day')->widget(dosamigos\datepicker\DatePicker::className(), [
        'language' => 'uk',
        'clientOptions' => [
            'autoclose' => true,

        ]
    ]); ?>

    <?= $form->field($model, 'passport_code')->widget(\yii\widgets\MaskedInput::className(), ['mask' => 'AA №999999']) ?>

    <?= $form->field($model, 'passport_issued')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('passport_issued')]) ?>

    <?= $form->field($model, 'passport_issued_date')->widget(dosamigos\datepicker\DatePicker::className(), [
        'language' => 'uk',
        'clientOptions' => [
            'autoclose' => true,

        ]
    ]); ?>

    <?= $form->field($model, 'birth_certificate')->widget(\yii\widgets\MaskedInput::className(), ['mask' => 'AA №999999']);
    ?>

    <?= $form->field($model, 'tax_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sseed_id')->textInput() ?>
    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 12, // the maximum times, an element can be cloned (default 999)
        'min' => 0, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelsFamily[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'last_name',
            'first_name',
            'middle_name',
            'work_place',
            'work_position',
            'phone1',
            'phone2',
            'email',
        ],
    ]); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-users"></i> <?= Yii::t('app', 'Family') ?>
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i
                    class="fa fa-plus"></i> <?= Yii::t('app', 'Add ties') ?></button>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items"><!-- widgetContainer -->
            <?php foreach ($modelsFamily as $index => $modelFamily): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <span class="panel-title-address">Address: <?= ($index + 1) ?></span>
                        <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i
                                class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        // necessary for update action.
                        if (!$modelFamily->isNewRecord) {
                            echo Html::activeHiddenInput($modelFamily, "[{$index}]id");
                        }
                        ?>
                        <?= $form->field($modelFamily, "[{$index}]type_id")->dropDownList(FamilyTiesType::getList(), ['prompt' => Yii::t('app', 'Select') . ' ' . Yii::t('app', 'Family tie type')]); ?>

                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($modelFamily, "[{$index}]last_name")->textInput() ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelFamily, "[{$index}]first_name")->textInput() ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelFamily, "[{$index}]middle_name")->textInput() ?>
                            </div>
                        </div><!-- end:row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelFamily, "[{$index}]work_place")->textInput() ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelFamily, "[{$index}]work_position")->textInput() ?>
                            </div>
                        </div><!-- end:row -->

                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($modelFamily, "[{$index}]phone1")->textInput() ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelFamily, "[{$index}]phone2")->textInput() ?>
                            </div>
                            <div class="col-sm-4">
                                <?= $form->field($modelFamily, "[{$index}]email")->textInput() ?>
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
    <?php \yii\widgets\Pjax::end(); ?>
</div>