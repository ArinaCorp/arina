<?php
/**
 * @var PlanController $this
 * @var StudyPlan $model
 */
$this->breadcrumbs = array(
    'Робочі плани'=> $this->createUrl('main/index'),
    'Новий робочий план'
);
?>
    <h2>Створення нового робочого плану</h2>
<?php $this->renderPartial('_form', array('model' => $model)); ?>