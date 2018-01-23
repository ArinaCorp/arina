<?php

use yii\bootstrap\Html;
use app\modules\employee\models\EmployeeEducation;

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
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, "[{$index}]name_of_institution")->textInput() ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, "[{$index}]document")->textInput() ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, "[{$index}]graduation_year")->textInput() ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, "[{$index}]speciality")->textInput() ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, "[{$index}]qualification")->textInput() ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, "[{$index}]education_form")->textInput() ?>
            </div>
        </div>
    </div>
</div>
