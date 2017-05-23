<?php

use yii\web\View;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

use app\modules\load\models\Load;

/**
 * @var $this View
 * @var $model Load
 */
?>
<div class="row">
    <?php Pjax::begin(); ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']) ?>

    <?=Html::a(Yii::t('app', 'Return'), ['/load'], ['class' => 'btn btn-danger']) ?>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>
    <br/>
</div>