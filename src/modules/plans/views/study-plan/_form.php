<?php

use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

use app\modules\directories\models\speciality\Speciality;
use app\modules\plans\models\StudyPlan;
use app\modules\plans\widgets\Graph;

/**
 * @var $this View
 * @var $model StudyPlan
 * @var ActiveForm $form
 */
?>

<div class="study-plan-form">
    <?php Pjax::begin(); ?>

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo Html::label(Yii::t('plans', 'Choose speciality'), 'origin', array('class' => 'control-label')); ?>

    <?= Html::activeDropDownList($model, 'id', ArrayHelper::map(Speciality::find()->all(), 'id', 'title'))?>

    <?php if ($model->isNewRecord): ?>
        <div class="control-group">
            <?php echo Html::label(Yii::t('plans', 'Base plan'), 'origin', array('class' => 'control-label')); ?>

            <?php echo Html::dropDownList('origin', '', ArrayHelper::map(StudyPlan::find()->all(),
                'id', 'speciality_id'), ['empty' => '','class'=>'span6']); ?>

        </div>
    <?php endif; ?>

    <?= Graph::widget(['model' => $model, 'field' => '', 'graph' => $model->graphs]) ?>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>
</div>