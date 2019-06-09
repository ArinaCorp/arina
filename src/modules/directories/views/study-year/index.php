<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('app', 'Study years list');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="study-year-index">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Adding new study year'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            [
                'attribute' => 'active',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $widget) {
                    /* @var $model \app\modules\directories\models\StudyYear */
                    return Html::checkbox('active', $model->active, ['disabled' => 'disabled']);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete} {update}',
            ],
        ],
    ]); ?>
</div>
