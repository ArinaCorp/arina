<?php
/**
 * @var StudyYear $year
 * @var  TbActiveForm $form
 * @var LoadDocGenerateModel $model
 * @author Dmytro Karpovych <ZAYEC77@gmail.com>
 */
$this->breadcrumbs = array(
    Yii::t('base', 'Load') => $this->createUrl('index'),
    $year->title => $this->createUrl('view', array('id' => $year->id)),
    'Генерація документів'
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

<?php echo $form->errorSummary($model); ?>
<?php echo $form->dropDownListRow($model, 'type', LoadDocGenerateModel::getTypesList(), array('empty' => 'Виберіть тип')); ?>
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
            'update' => '#LoadDocGenerateModel_teacherId',
            'data' => array('id' => 'js:this.value'),
        )
    )
); ?>
<?php echo $form->dropDownListRow($model, 'teacherId', array(), array('empty' => '', 'class' => 'span6')); ?>
<?php echo $form->dropDownListRow($model, 'groupId', CHtml::listData(Group::model()->findAll(),'id','title','speciality.title'), array('empty' => '', 'class' => 'span6')); ?>

    <div class="form-actions">
        <?php $this->widget(
            BoosterHelper::BUTTON,
            array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => 'Генерувати',
            )
        ); ?>
    </div>

    <script>

    </script>
<?php $this->endWidget(); ?>