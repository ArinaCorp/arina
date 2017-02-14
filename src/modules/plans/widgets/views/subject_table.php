<?php

use yii\db\ActiveRecord;
use yii\grid\GridView;
use app\modules\plans\widgets\SubjectTable;

/**
 * @var $this SubjectTable
 * @var $dataProvider ActiveRecord
 */
$semesterColumns = array();
for ($i = 0; $i < 8; $i++)
    $semesterColumns[] = array('header' => $i + 1, 'value' => '$data->weeks[' . $i . ']');
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        ['class' => 'yii\grid\ActionColumn'],
    ],
]);
?>

<?/*
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'dataProvider' => $dataProvider,
    'responsiveTable' => true,
    'type' => 'striped bordered',
    'columns' => array_merge(
        array(
            array(
                'name' => 'subject_id',
                'value' => '$data->subject->title',
            ),
            array('name' => 'total'),
            array('name' => 'classes'),
            array('name' => 'lectures'),
            array('name' => 'labs'),
            array('name' => 'practices'),
            array('name' => 'testSemesters'),
            array('name' => 'examSemesters'),
            array('name' => 'workSemesters'),
            array('name' => 'projectSemesters'),
        ),
        $semesterColumns,
        array(
            array(
                'header' => Yii::t('base', 'Actions'),
                'template' => '{update}{delete}',
                'class' => BoosterHelper::GRID_BUTTON_COLUMN,
                'updateButtonUrl' => 'Yii::app()->createUrl("studyPlan/plan/editSubject", array("id" => $data->id))',
                'deleteButtonUrl' => 'Yii::app()->createUrl("studyPlan/plan/deleteSubject", array("id" => $data->id))',
            )
        )
    ),
));