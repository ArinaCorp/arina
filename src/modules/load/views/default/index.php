<?php
/**
 * @var MainController $this
 * @var CActiveDataProvider $dataProvider
 */
$this->breadcrumbs = array(
    Yii::t('base', 'Load'),
);

$this->menu = array(
    array(
        'label' => 'Створити навантаження',
        'url' => $this->createUrl('create'),
        'type' => 'primary',
    ),
);
?>
<?php $this->widget(BoosterHelper::GRID_VIEW, array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'header' => 'Навчальний рік',
            'value' => 'CHtml::link($data->title, Yii::app()->createUrl("/load/main/view", array("id"=>$data->id)))',
            'type' => 'raw',
        ),
        array(
            'class' => BoosterHelper::GRID_BUTTON_COLUMN,
            'template' => '{view}',
        ),
    ),
)); ?>


