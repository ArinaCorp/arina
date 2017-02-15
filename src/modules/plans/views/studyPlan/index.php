<?php
/**
 * @var PlanController $this
 * @var CActiveDataProvider $dataProvider
 */
$this->breadcrumbs = array(
    Yii::t('base', 'Study plans') => $this->createUrl('/studyPlan'),
);
?>

<?php $this->widget(BoosterHelper::GRID_VIEW, array(
    'dataProvider' => $dataProvider,
    'responsiveTable' => false,
    'columns' => array(
        array(
            'name' => 'speciality.title',
            'value' => 'CHtml::link($data->speciality->title, array("view", "id"=>$data->id))',
            'type' => 'raw'
        ),
        array(
            'name' => 'updated',
            'value' => 'date("d.m.Y H:i:s", $data->updated)'
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}{delete}{view}{excel}',
            'viewButtonUrl' => 'Yii::app()->createUrl("studyPlan/plan/view", array("id"=>$data->id))',
            'updateButtonUrl' => 'Yii::app()->createUrl("studyPlan/plan/update", array("id"=>$data->id))',
            'deleteButtonUrl' => 'Yii::app()->createUrl("studyPlan/plan/delete", array("id"=>$data->id))',
            'buttons' => array(
                'excel' => array(
                    'label' => Yii::t('base', 'Create document'),
                    'icon' => 'icon-file',
                    'url' => 'Yii::app()->createUrl("/studyPlan/plan/makeExcel", array("id"=>$data->id))',
                ),
            ),
        )
    ),
));