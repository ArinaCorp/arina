<?php

use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

use app\modules\plans\models\WorkPlan;
use app\modules\directories\models\speciality\Speciality;
use app\modules\plans\models\StudyPlan;
use app\modules\directories\models\StudyYear;

/**
 * @var View $this
 * @var WorkPlan $model
 * @var ActiveForm $form
 */
?>

<div class="study-plan-form">
    <?php Pjax::begin(); ?>

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= Yii::t('plans','Choose speciality'),Html::activeDropDownList($model, 'id',
        ArrayHelper::map(Speciality::find()->all(), 'id', 'title'), ['class'=>'span5'])?>
    <br/>

    <?= Yii::t('plans','Choose study year'),Html::activeDropDownList($model, 'study_year_id',
        ArrayHelper::map(StudyYear::find()->all(), 'id', 'year_start'), ['class'=>'span5'])?>
    <br/>

    <?php if ($model->isNewRecord): ?>

        <?= Html::activeDropDownList($model, 'study_plan_origin',
            ArrayHelper::map(StudyPlan::find()->all(), 'id', 'title'), ['class'=>'span5'])?>
        <br/>

        <?= Html::activeDropDownList($model, 'work_plan_origin',
            ArrayHelper::map(WorkPlan::find()->all(), 'id', 'title'), ['class'=>'span5'])?>

    <?php endif; ?>

    <?= $this->render('_form_buttons', [
        'model' => $model,
    ]) ?>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>
</div>