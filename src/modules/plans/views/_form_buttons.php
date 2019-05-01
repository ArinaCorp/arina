<?php

use app\modules\plans\models\StudyPlan;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var $plan boolean
 * @var $this View
 * @var $model StudyPlan
 */
?>
<div class="form-actions">
    <?php Pjax::begin(); ?>

    <?php $form = ActiveForm::begin(); ?>

    <p>
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']) ?>

        <?= Html::a(Yii::t('app', 'Return'), $plan ? ['/plans/study-plan'] : ['/plans/work-plan'], ['class' => 'btn btn-danger']) ?>
    </p>
    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>
</div>