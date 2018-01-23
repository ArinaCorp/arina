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

use app\assets\DynamicFormAsset;
use app\modules\students\models\FamilyRelation;

DynamicFormAsset::register($this);

$this->registerJs(<<<JS
jQuery('#familyRelationForm').dynamicForm();
JS
);
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default" id="familyRelationForm">
            <div class="panel-heading">
                <i class="fa fa-users"></i> <?= Yii::t('app', 'Family') ?>
                <button data-pjax="0" class="pull-right add-item btn btn-success btn-xs">
                    <i class="fa fa-plus"></i>
                    <?= Yii::t('app', 'Add ties') ?>
                </button>
                <div class="clearfix"></div>
            </div>

            <div class="panel-body items">
                <div class="form-template">
                    <?= $this->render('_family_item', [
                        'model' => new FamilyRelation(),
                        'form' => $form,
                        'index' => 'new_ITEM_INDEX',
                    ]) ?>
                </div>
                <?php foreach ($model->familyRelationsList as $index => $modelFamily): ?>
                    <?= $this->render('_family_item', [
                        'model' => $modelFamily,
                        'form' => $form,
                        'index' => $index,
                    ]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>