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

    <?= Html::a($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'),
        ['/plans/study-plan'], ['class' => 'btn btn-primary']) ?>

    <?= Html::a(Yii::t('base', 'Cancel'), ['/plans/study-plan'], ['class' => 'btn btn-danger']) ?>

    <?= Html::a(Yii::t('plans', 'Return'), ['/plans/study-plan'], ['class' => 'btn btn-info']) ?>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>
</div>