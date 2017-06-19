<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\accounting\models\AccountingYear */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Accounting Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounting-year-view">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?=  Html::a(Yii::t('app', 'List'), Url::to(['/accounting/accounting-ye/view', 'id' => $model->teacher_id]), ['class' => 'btn btn-success']) ?>
        <?= Html::a('Оновити', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    <p><?php // Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?></p>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'teacher_id',
            'subject_id',
            'mounth',
        ],
    ]) ?>

</div>
