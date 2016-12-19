<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\modules\employee\models\EmployeeSearch;

/* @var $this View
 * @var $model EmployeeSearch
 * @var $form ActiveForm */

?>

<div class="employee-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'is_in_education') ?>

    <?= $form->field($model, 'position_id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'middle_name') ?>

    <?= $form->field($model, 'last_name') ?>

    <?= $form->field($model, 'gender') ?>

    <?= $form->field($model, 'cyclic_commission_id') ?>

    <?= $form->field($model, 'birth_date') ?>

    <?= $form->field($model, 'passport') ?>

    <?= $form->field($model, 'passport_issued_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
