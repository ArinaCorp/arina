<?php
/**
 * @var MainController $this
 * @var Load $model
 * @var TbActiveForm $form
 */
$this->breadcrumbs = array(
    Yii::t('base', 'Load') => $this->createUrl('index'),
    $model->studyYear->title => $this->createUrl('view', array('id' => $model->study_year_id)),
    'Розподіл курсових робіт, проектів'
);
?>
<?php $form = $this->beginWidget(
    BoosterHelper::FORM,
    array(
        'id' => 'load-update-form',
        'type' => 'horizontal',
        'htmlOptions' => array('class' => 'well'),
    )
); ?>
    <h2>Розподіл курсових робіт, проектів</h2>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->dropDownListRow(
    $model,
    'commissionId',
    CyclicCommission::getList(),
    array(
        'class' => 'span6',
        'empty' => '',
        'ajax' => array(
            'type' => 'GET',
            'url' => $this->createUrl('/teacher/listByCycle'),
            'update' => '#Load_teacher_id',
            'data' => array('id' => 'js:this.value'),
        )
    )
); ?>
<?php echo $form->dropDownListRow($model, 'teacher_id', array(), array('empty' => '', 'class' => 'span6')); ?>
<?php echo $form->dropDownListRow($model, 'wp_subject_id', WorkSubject::getListByYear($model->study_year_id, true), array('empty' => '', 'class' => 'span6')); ?>
<?php echo $form->dropDownListRow($model, 'group_id', Group::getTreeList(), array('empty' => '', 'class' => 'span6')); ?>
<?php echo $form->dropDownListRow($model, 'workType', Load::getTypes(), array('empty' => '', 'class' => 'span6')); ?>
<?php echo $form->numberFieldRow($model, 'students[0]', array('class' => 'span6', 'readonly' => true)); ?>
<?php echo $form->numberFieldRow($model, 'students[1]', array('class' => 'span6')); ?>
<?php echo $form->numberFieldRow($model, 'students[2]', array('class' => 'span6')); ?>

<?php $this->renderPartial('//formButtons', array('model' => $model)); ?>
<?php $this->endWidget(); ?>

<script>
    function updateStudentsCount() {
        var count = 0;
        count += parseInt($("#Load_students_1").val());
        count += parseInt($("#Load_students_2").val());
        $("#Load_students_0").val(count);
    }

    $(function () {
        $('#Load_students_1').change(updateStudentsCount);
        $('#Load_students_2').change(updateStudentsCount);
    });
</script>