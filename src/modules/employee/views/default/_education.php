<?php

use app\assets\DynamicFormAsset;
use app\modules\employee\models\EmployeeEducation;

/**
 * @var $modelsEducation \app\modules\employee\models\EmployeeEducation[]
 * @var \app\modules\employee\models\Employee $model
 */

DynamicFormAsset::register($this);

$this->registerJs(<<<JS
jQuery('#educationForm').dynamicForm();
JS
);
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default" id="educationForm">
            <div class="panel-heading">
                <i class="fa fa-users"></i> <?= Yii::t('app', 'Education') ?>
                <button data-pjax="0" class="pull-right add-item btn btn-success btn-xs">
                    <i class="fa fa-plus"></i>
                    <?= Yii::t('app', 'Add educations') ?>
                </button>
                <div class="clearfix"></div>
            </div>

            <div class="panel-body items">
                <div class="form-template">
                    <?= $this->render('_education_item', [
                        'model' => new EmployeeEducation(),
                        'form' => $form,
                        'index' => 'new_ITEM_INDEX',
                    ]) ?>
                </div>
                <?php foreach ($model->employeeEducationList as $index => $modelEducation): ?>
                    <?= $this->render('_education_item', [
                        'model' => $modelEducation,
                        'form' => $form,
                        'index' => $index,
                    ]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
