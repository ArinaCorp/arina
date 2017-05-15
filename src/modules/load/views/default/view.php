<?php
/**
 * @var MainController $this
 * @var StudyYear $year
 * @var CActiveDataProvider $dataProvider
 * @var Load $model
 * @var TbActiveForm $form
 */
$this->breadcrumbs = array(
    Yii::t('base', 'Load') => $this->createUrl('index'),
    $year->title
);

$this->menu = array(
    array(
        'label' => 'Генерувати навантаження',
        'url' => $this->createUrl('generate', array('id' => $year->id)),
        'type' => 'primary',
    ),
    array(
        'label' => 'Розподілити курсові роботи, проекти',
        'url' => $this->createUrl('project', array('id' => $year->id)),
        'type' => 'info'
    ),
    array(
        'label' => 'Генерувати документ',
        'url' => $this->createUrl('doc', array('id' => $year->id)),
        'type'=>'info',
    ),
);
Yii::app()->clientScript->registerScript(
    'load-buttons',
    '
       function toggleSection(section, sender) {
           $("."+section).toggle();
           $(sender).toggleClass("btn-info");
           $(sender).toggleClass("btn-warning");
       }
   ',
    CClientScript::POS_END
);
?>
<div class="well">
<h2>Навантаження на <?php echo $year->title; ?> навчальний рік</h2>

<?php $form = $this->beginWidget(BoosterHelper::FORM, array('id' => 'load-filter-form', 'method' => 'GET')); ?>
<?php echo $form->dropDownListRow(
    $model,
    'commissionId',
    CyclicCommission::getList(),
    array(
        'class' => 'span6',
        'empty' => '',
        'ajax' => array(
            'type' => 'GET',
            'url' => $this->createUrl('/teacher/listByCycle'), //url to call.
            'update' => '#Load_teacher_id',
            'data' => array('id' => 'js:this.value'),
        )
    )
); ?>
<?php echo $form->dropDownListRow($model, 'teacher_id', array(), array('empty' => '', 'class' => 'span6')); ?>
<div class="form-actions">
    <?php echo TbHtml::submitButton('Фільтрувати', array('class' => 'btn-success')); ?>
    <?php echo TbHtml::link(
        'Скасувати фільтр',
        $this->createUrl('view', array('id' => $year->id)),
        array('class' => 'btn btn-danger')
    ); ?>
</div>
<?php $this->endWidget(); ?>
<hr/>

<div class="form-actions">
    <button onclick="toggleSection('general', this)" class="btn btn-info">Загальні дані</button>
    <button onclick="toggleSection('fall', this)" class="btn btn-info">Осінній семестр</button>
    <button onclick="toggleSection('spring', this)" class="btn btn-info">Весняний семестр</button>
</div>

    <?php $this->renderPartial('_subjects', array('model' => $model, 'dataProvider' => $dataProvider)); ?>

</div>

