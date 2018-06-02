<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\GroupExport */


?>
<div class="group-update">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $form = ActiveForm::begin(['method' => 'get']); ?>

    <div class="row">
        <div class="col-sm-2">
            <?= $form->field($model, 'telephone')->checkbox() ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'birth_day')->checkbox() ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'payment_type_label')->checkbox() ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Export', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
