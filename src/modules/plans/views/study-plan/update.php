<?php

use yii\web\View;
use yii\bootstrap\Html;

use app\modules\plans\models\StudyPlan;
use app\modules\plans\widgets\SubjectTable;
use yii\helpers\Url;

/**
 * @var $this View
 * @var $model StudyPlan
 */

$this->title = Yii::t('plans', 'Study plan editing');

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Study plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', ['id' => $model->id, 'graph'=>$model->graph]]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <?= SubjectTable::widget(['subjectDataProvider' => $model->getStudyPlanStudySubjectProvider()]) ?>

    <?= Html::a(Yii::t('plans', 'Add subject'), ['create-subject', 'id' => $model->id], ['class' => 'btn btn-success']); ?>
    <br/><br/>
</div>