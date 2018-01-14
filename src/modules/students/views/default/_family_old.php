<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.03.2017
 * Time: 9:08
 */

/**
 * @var \yii\web\View $this
 * @var \app\modules\students\models\Student $model
 */

use app\modules\students\models\FamilyRelation;
use app\widgets\DynamicFormWidget;

?>
<div class="row">
    <div class="col-md-12">

        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'family_relation_wrapper',
            'widgetBody' => '.container-items-family-relation',
            'widgetItem' => '.item-family-relation',
            'limit' => 4,
            'min' => 0,
            'insertButton' => '.add-item-family-relation',
            'deleteButton' => '.remove-item-family-relation',
            'model' => new FamilyRelation(),
            'formId' => 'studentForm',
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

        <div class="panel panel-default" id="familyRelationForm">
            <div class="panel-heading">
                <i class="fa fa-users"></i> <?= Yii::t('app', 'Family') ?>
                <button data-pjax="0"
                        class="pull-right add-item-family-relation btn btn-success btn-xs">
                    <i class="fa fa-plus"></i>
                    <?= Yii::t('app', 'Add ties') ?>
                </button>
                <div class="clearfix"></div>
            </div>

            <div class="panel-body container-items-family-relation">
                <div class="item-family-relation">
                    <?= $this->render('_family_item', [
                        'model' => new FamilyRelation(),
                        'form' => $form,
                    ]) ?>
                </div>
                <?php foreach ($model->familyRelationsList as $modelFamily): ?>
                    <?= $this->render('_family_item', [
                        'model' => $modelFamily,
                        'form' => $form,
                    ]) ?>
                <?php endforeach; ?>
            </div>
        </div>

        <?php DynamicFormWidget::end(); ?>
    </div>
</div>