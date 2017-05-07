<?php
/**
 * @var WorkController $this
 * @var WorkPlan $model
 * @var TbActiveForm $form
 */
?>


<?php $form = $this->beginWidget(
    BoosterHelper::FORM,
    array(
        'type' => 'horizontal',
        'htmlOptions' => array(
            'class' => 'well',
        ),
    )
); ?>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->dropDownListRow(
    $model,
    'speciality_id',
    Speciality::getList(Yii::app()->user->identityId),
    array('empty' => 'Оберіть спеціальність', 'class'=>'span5')
); ?>
<?php echo $form->dropDownListRow($model, 'year_id', StudyYear::getList(), array('empty' => '', 'class'=>'span5')); ?>
<?php if ($model->isNewRecord): ?>
    <?php echo $form->dropDownListRow(
        $model,
        'plan_origin',
        StudyPlan::getList(Yii::app()->user->identityId) ,
        array('empty' => '', 'class'=>'span5')
    ); ?>
    <?php echo $form->dropDownListRow(
        $model,
        'work_origin',
        WorkPlan::getList(Yii::app()->user->identityId),
        array('empty' => '', 'class'=>'span5')
    ); ?>
<?php endif; ?>

<?php $this->renderPartial('//formButtons', array('model' => $model)); ?>
<?php $this->endWidget(); ?>