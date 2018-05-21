<?php
/**
 * @var \yii\web\View $this
 * @var \app\modules\load\models\Load $model
 * @var ActiveForm $form
 */

use app\modules\employee\models\Teacher;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

//$this->breadcrumbs = array(
//    Yii::t('base', 'Load') => $this->createUrl('index'),
//    $model->studyYear->title => $this->createUrl('view', array('id' => $model->study_year_id)),
//    $model->planSubject->subject->title . ' для ' . $model->group->title
//);
?>
<?php $form = ActiveForm::begin([
        'id' => 'load-update-form',
    'layout' => 'horizontal',
    'options' => ['class' => 'well'],
]);
?>
<h2><?php echo $model->workSubject->subject->title . ' для ' . $model->group->title; ?></h2>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->field($model, 'employee_id')->dropDownList(Teacher::getListByCycle($model->workSubject->cyclic_commission_id),
    ['prompt' => 'Оберіть викладача', 'class' => 'span6']); ?>
<h3 class="central-header">Осінній семестр</h3>
<?php echo $form->field($model, 'fall_hours[0]')->textInput(array('class' => 'span6', 'labelOptions' => array('class' => 'label-width'))); ?>
<?php echo $form->field($model, 'fall_hours[1]')->textInput(array('class' => 'span6', 'labelOptions' => array('class' => 'label-width'))); ?>
<?php echo $form->field($model, 'consult[0]')->textInput(array('class' => 'span6', 'labelOptions' => array('class' => 'label-width'))); ?>
<h3 class="central-header">Весняний семестр</h3>
<?php echo $form->field($model, 'spring_hours[0]')->textInput(array('class' => 'span6', 'labelOptions' => array('class' => 'label-width'))); ?>
<?php echo $form->field($model, 'spring_hours[1]')->textInput(array('class' => 'span6', 'labelOptions' => array('class' => 'label-width'))); ?>
<?php echo $form->field($model, 'consult[1]')->textInput(array('class' => 'span6', 'labelOptions' => array('class' => 'label-width'))); ?>

<div class="form-actions">
    <?php echo Html::submitButton($model->isNewRecord ? Yii::t('base', 'Create') : Yii::t('base', 'Save'), [
        'buttonType' => 'submit',
        'type' => 'primary',
    ]); ?>
    <?php echo Html::resetButton(Yii::t('base', 'Cancel')); ?>
    <?php echo Html::a('Повернутись', Yii::$app->request->getReferrer(), array('class' => 'btn btn-info')); ?>
</div>
<?php ActiveForm::end(); ?>
