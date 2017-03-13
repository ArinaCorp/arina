<?php
/**
 * @var PlanController $this
 * @var StudyPlan $model
 */
$this->breadcrumbs = array(
    'Робочі плани' => $this->createUrl('index'),
    $model->speciality->title => $this->createUrl('view', array('id' => $model->id,'graph'=>$model->graph)),
);

$this->menu = array(
    array(
        'label' => 'Повернутись',
        'type' => 'primary',
        'url' => $this->createUrl('index')
    ),
    array(
        'label' => 'Редагувати предмети',
        'type' => 'info',
        'url' => $this->createUrl('subjects', array('id' => $model->id))
    ),
);
?>

    <h3>Редагування</h3>
<?php $this->renderPartial('_form', array('model' => $model)); ?>
<?php $this->renderPartial('graph', array('model'=>$model)); ?>