<?php

use yii\web\View;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;
use yii\helpers\Html;

use app\modules\plans\models\StudyPlan;

/**
 * @var $this View
 * @var $model StudyPlan
 */
?>
<div class="form-actions">
    <?php Pjax::begin(); ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?= Html::a(Yii::t('app', 'Return'), ['/plans/study-plan'], ['class' => 'btn btn-danger']) ?>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>
</div>