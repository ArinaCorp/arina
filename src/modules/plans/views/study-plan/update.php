<?php

use yii\web\View;

use app\modules\plans\models\StudyPlan;
use app\modules\plans\widgets\SubjectTable;

/**
 * @var $this View
 * @var $model StudyPlan
 */

$this->title = Yii::t('plans', 'Edit study plan');

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Study plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', ['id' => $model->id, 'graph'=>$model->graphs]]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="study-plan-update">
    <h3>
        <?=Yii::t('plans', 'Editing')?>
    </h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?= SubjectTable::widget(['subjectDataProvider' => $model->getPlanSubjectProvider()]) ?>
</div>