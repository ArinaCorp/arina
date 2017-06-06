<?php
/**
 * @var MainController $this
 * @var Load $model
 * @var TbActiveForm $form
 */
$this->breadcrumbs = array(
    Yii::t('base', 'Load') => $this->createUrl('index'),
    $model->studyYear->title => $this->createUrl('view', array('id' => $model->study_year_id)),
    $model->planSubject->subject->title . ' для ' . $model->group->title
);
?>
<?php $form = $this->beginWidget(
    BoosterHelper::FORM,
    array(
        'id' => 'load-update-form',
        'type' => 'horizontal',
        'htmlOptions' => array('class' => 'well'),
    )
); ?>
<h2><?php echo $model->planSubject->subject->title . ' для ' . $model->group->title; ?></h2>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->dropDownListRow(
    $model,
    'teacher_id',
    Teacher::getListByCycle($model->planSubject->cyclic_commission_id),
    array('empty' => 'Оберіть викладача', 'class'=>'span6'), array('labelOptions'=>array('class'=>'label-width'))
); ?>
<h3 class="central-header">Осінній семестр</h3>
<?php echo $form->numberFieldRow($model, 'fall_hours[0]', array('class'=>'span6'), array('labelOptions'=>array('class'=>'label-width'))); ?>
<?php echo $form->numberFieldRow($model, 'fall_hours[1]', array('class'=>'span6'), array('labelOptions'=>array('class'=>'label-width'))); ?>
<?php echo $form->numberFieldRow($model, 'consult[0]', array('class'=>'span6'), array('labelOptions'=>array('class'=>'label-width'))); ?>
<h3 class="central-header">Весняний семестр</h3>
<?php echo $form->numberFieldRow($model, 'spring_hours[0]', array('class'=>'span6'), array('labelOptions'=>array('class'=>'label-width'))); ?>
<?php echo $form->numberFieldRow($model, 'spring_hours[1]', array('class'=>'span6'), array('labelOptions'=>array('class'=>'label-width'))); ?>
<?php echo $form->numberFieldRow($model, 'consult[1]', array('class'=>'span6'), array('labelOptions'=>array('class'=>'label-width'))); ?>


<?php $this->renderPartial('//formButtons', array('model' => $model)); ?>
<?php $this->endWidget(); ?>
