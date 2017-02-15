<?php
/**
 * @var PlanController $this
 * @var StudyPlan $model
 * @var TbActiveForm $form
 */
?>


<?php $form = $this->beginWidget(BoosterHelper::FORM, array(
    'type' => 'horizontal',
    'htmlOptions' => array(
        'class' => 'well',
    ),
)); ?>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->dropDownListRow($model, 'speciality_id', Speciality::getList(Yii::app()->getUser()->identityId), array('empty' => 'Оберіть спеціальність','class'=>'span6')); ?>
<?php if ($model->isNewRecord): ?>
    <div class="control-group">
        <?php echo CHtml::label('План для основи', 'origin', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo TbHtml::dropDownList('origin', '', CHtml::listData(StudyPlan::model()->findAll(), 'id', 'title'), array('empty' => '','class'=>'span6')); ?>
        </div>
    </div>
<?php endif; ?>
<?php $this->widget('studyPlan.widgets.Graph', array('model' => $model, 'field' => '', 'graph' => $model->graph)); ?>
<?php $this->renderPartial('//formButtons', array('model' => $model)); ?>
<?php $this->endWidget(); ?>