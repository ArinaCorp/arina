<?php

use app\modules\rbac\models\ActionAccess;
use app\modules\rbac\models\AuthItem;
use kartik\select2\Select2;
use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model ActionAccess
 * @var $isUpdated boolean
 */

?>

<div class="row">
    <div class="col-lg-4">
        <?php if ($isUpdated): ?>

            <?= Alert::widget([
                'options' => [
                    'class' => 'alert-success'
                ],
                'body' => Yii::t('rbac', 'Accesses have been updated'),
            ]) ?>

        <?php endif ?>

        <?php $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'enableAjaxValidation' => false,
        ]) ?>

        <?= Html::activeHiddenInput($model, 'id') ?>

        <?= $form->field($model, 'items')->widget(Select2::class, [
            'data' => AuthItem::getDropDownArray('name', 'description'),
            'options' => [
                'id' => 'items',
                'multiple' => true
            ],
        ])->label(Yii::t('rbac', 'Items')) ?>

        <?= Html::submitButton(Yii::t('rbac', 'Update items'), ['class' => 'btn btn-success btn-block']) ?>

        <?php ActiveForm::end() ?>
    </div>
</div>