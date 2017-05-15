<?php
/**
 * @var MainController $this
 */
$this->breadcrumbs = array(
    Yii::t('base', 'Load') => $this->createUrl('index'),
    'Нове навантаження'
);
?>
<div class="well">
    <?php echo CHtml::beginForm('', 'post', array('style' => 'width: 405px; margin: auto auto')); ?>
    <h2>Створення навантаження</h2>
    <?php echo CHtml::label('Навчальний рік', 'study_year'); ?>
    <?php echo CHtml::dropDownList('study_year', '', StudyYear::getList()); ?>
    <div>
        <?php echo CHtml::submitButton('Створити', array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link('Повернутись', $this->createUrl('index'), array('class' => 'btn btn-info')); ?>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>

