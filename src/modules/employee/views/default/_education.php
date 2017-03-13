<?php

use yii\bootstrap\Html;

/**
 * @var $modelsEducation \app\modules\employee\models\EmployeeEducation[]
 */

?>

<div class="panel panel-default education">
    <div class="panel-heading">
        <i class="fa fa-users"></i> <?= Yii::t('app', 'Education') ?>
        <button data-action="add-education" type="button"
                class="pull-right action-button add-item btn btn-success btn-xs"><i
                    class="fa fa-plus"></i> <?= Yii::t('app', 'Add education') ?></button>
        <div class="clearfix"></div>
    </div>

    <div class="panel-body container-items"><!-- widgetContainer -->
        <?php foreach ($modelsEducation as $index => $modelEducation): ?>
        <div class="item panel panel-default"><!-- widgetBody -->
            <div class="panel-heading">
                    <span class="panel-title-address"><?= Yii::t('app', 'Education') ?>
                        : <?= ($index + 1) ?></span>
                <button type="button" class="pull-right action-button remove-item btn btn-danger btn-xs"
                        data-key="<?= $index ?>"
                        data-action="remove-education"><i
                        class="fa fa-minus"> </i></button>
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
                        <?= $form->field($modelEducation, "[{$index}]education_form")->textInput() ?>
                    </div>
                </div>
            </div><!-- end:row -->
        </div>
        <?php endforeach; ?>
    </div>
</div>
