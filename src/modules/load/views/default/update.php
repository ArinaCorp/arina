<?php
/**
 * @var \yii\web\View $this
 * @var \app\modules\load\models\Load $model
 * @var ActiveForm $form
 */

use app\modules\employee\models\Teacher;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


//@TODO replace labels by Yii::t
$this->title = $model->workSubject->subject->title . ' для ' . $model->group->title;
?>

<div class="load-update">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= $this->title ?>
            </h1>
        </div>
    </div>


    <p>
        <?= Html::a(Yii::t('app', 'Loads'), Yii::$app->request->getReferrer() ?? ['/load/index', 'id' => $model->study_year_id], ['class' => 'btn btn-info']); ?>
    </p>

    <?php $form = ActiveForm::begin(['id' => 'load-update-form']) ?>

    <?= $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-lg-6">
            <?php //@TODO replace to select2 ?>
            <?= $form->field($model, 'employee_id')
//                ->dropDownList(Teacher::getListByCycle($model->workSubject->cyclic_commission_id), ['prompt' => 'Оберіть викладача']);
                ->dropDownList(Teacher::getMap('fullName', 'id', [], false), ['prompt' => 'Оберіть викладача']);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <h3 class="central-header">Осінній семестр</h3>
            <?= $form->field($model, 'fall_hours[0]')->textInput()
                ->label(Yii::t('load', 'Calculation and control works')); ?>
            <?= $form->field($model, 'fall_hours[1]')->textInput()
                ->label(Yii::t('load', 'Practice management, diploma control, state qualification commissions')); ?>
            <?= $form->field($model, 'consult[0]')->textInput()
                ->label(Yii::t('load', 'Consultations')); ?>
        </div>
        <div class="col-lg-6">
            <h3 class="central-header">Весняний семестр</h3>
            <?= $form->field($model, 'spring_hours[0]')->textInput()
                ->label(Yii::t('load', 'Calculation and control works')); ?>
            <?= $form->field($model, 'spring_hours[1]')->textInput()
                ->label(Yii::t('load', 'Practice management, diploma control, state qualification commissions')); ?>
            <?= $form->field($model, 'consult[1]')->textInput()
                ->label(Yii::t('load', 'Consultations')); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('base', 'Cancel'), ['class' => 'btn btn-danger']); ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>