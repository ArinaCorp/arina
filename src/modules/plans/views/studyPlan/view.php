<?php
/**
 * @var PlanController $this
 * @var StudyPlan $model
 */
$this->breadcrumbs = array(
    Yii::t('base', 'Study plans') => $this->createUrl('index'),
    $model->speciality->title,
);
?>

<div class="row well">
    <h3><?php echo $model->speciality->title; ?></h3>

    <p>Дата створення: <?php echo date('d.m.Y', $model->created); ?></p>
    <?php echo CHtml::link('Експортувати', $this->createUrl('makeExcel', array('id' => $model->id)), array('class' => 'btn btn-primary')); ?>
    <?php echo CHtml::link('Редагувати предмети', $this->createUrl('subjects', array('id' => $model->id)), array('class' => 'btn btn-primary')); ?>
    <br/>
    <?php $this->widget('studyPlan.widgets.Graph', array('model' => $model, 'field' => '', 'readOnly' => true, 'graph' => $model->graph)); ?>
    <br/>
<?php $this->widget('studyPlan.widgets.SubjectTable', array(
    'subjectDataProvider' => $model->getPlanSubjectProvider()
));