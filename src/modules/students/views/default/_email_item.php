<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2018 NRE
 *
 * @var integer|boolean $index
 * @var \app\modules\students\models\FamilyRelation $model
 * @var \yii\widgets\ActiveForm $form
 */

use app\modules\students\models\StudentsEmail;
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
        <?= $form->field($model, "[{$index}]email")->textInput() ?>
    </div>
</div>
