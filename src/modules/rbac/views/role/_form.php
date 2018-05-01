<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\rbac\models\Role;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var $this View
 * @var $model Role
 */

?>

<div class="role-form">
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
    ]) ?>

    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'name') ?>

            <?= $form->field($model, 'description') ?>

            <?= $form->field($model, 'rule') ?>

            <?= $form->field($model, 'children')->widget(Select2::className(), [
                'data' => $model->getUnassignedItems(),
                'options' => [
                    'id' => 'children',
                    'multiple' => true
                ],
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('rbac', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
