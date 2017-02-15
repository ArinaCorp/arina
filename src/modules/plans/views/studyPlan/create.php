<?php
/**
 * @var PlanController $this
 * @var StudyPlan $model
 */
$this->breadcrumbs = array(
    Yii::t('base', 'Study plans') => $this->createUrl('main/index'),
    Yii::t('studyPlan', 'New study plan'),
);
?>
    <h2>Створення нового навчального плану</h2>
<?php $this->renderPartial('_form', array('model' => $model)); ?>