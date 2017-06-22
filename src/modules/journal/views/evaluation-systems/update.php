<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\evaluation\EvaluationSystem */

$this->title = Yii::t('app', 'Update Evaluation System') . ': ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Evaluation Systems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="evaluation-system-update">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
