<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2018 NRE
 *
 * @var integer|boolean $index
 * @var \app\modules\students\models\FamilyRelation $model
 * @var \yii\widgets\ActiveForm $form
 */

use app\modules\students\models\FamilyRelationType;
use yii\helpers\Html;

?>

<div class="panel panel-default item" data-key="<?= $index ?>">
    <div class="panel-heading">
        <button data-pjax="0" class="pull-right remove-item btn btn-danger btn-xs">
            <i class="fa fa-minus"></i>
        </button>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body">
        <?php if (!$model->isNewRecord): ?>
            <?= Html::activeHiddenInput($model, "[{$index}]id"); ?>
        <?php endif ?>
        <?= $form->field($model, "[{$index}]type_id")->dropDownList(FamilyRelationType::getMap('title'), [
            'prompt' => Yii::t('app', 'Select') . ' ' . Yii::t('app', 'Family tie type'),
        ]); ?>

        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, "[{$index}]last_name")->textInput() ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, "[{$index}]first_name")->textInput() ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, "[{$index}]middle_name")->textInput() ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, "[{$index}]work_place")->textInput() ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, "[{$index}]work_position")->textInput() ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, "[{$index}]phone1")->textInput(['data' => ['mask' => '+99 (999) 999-9999']]); ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, "[{$index}]phone2")->textInput(['data' => ['mask' => '+99 (999) 999-9999']]); ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, "[{$index}]email")->textInput() ?>
            </div>
        </div>
    </div>
</div>
