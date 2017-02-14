<?php
/**
 * @var WorkController $this
 * @var WorkPlan $model
 * @var TbActiveForm $form
 */
$this->breadcrumbs = array(
    'Робочі плани' => $this->createUrl('index'),
    $model->speciality->title . ': ' . $model->year->title => $this->createUrl('view', array('id' => $model->id)),
);
$this->menu = array(
    array(
        'label' => 'Додати предмет',
        'type' => 'info',
        'url' => $this->createUrl('addSubject', array('id' => $model->id)),
    ),
    array(
        'label' => 'Повернутись',
        'type' => 'primary',
        'url' => $this->createUrl('index'),
    ),
);
?>
<?php $this->renderPartial('_subjects', array('model' => $model)); ?>