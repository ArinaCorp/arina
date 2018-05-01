<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac', 'Action Accesses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-access-index">

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?= Html::encode($this->title) ?>
        </h1>
    </div>
</div>


    <p>
        <?= Html::a(Yii::t('rbac', 'Create Action Access'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="table-responsive">
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'module',
            'controller',
            'action',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {addItems}',
                'buttons' => [
                    'addItems' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-list"></span>', ['add-items',
                            'id' => $model->id,
                        ], [
                            'title' => Yii::t('app', 'Add items'),
                            'aria-label' => Yii::t('app', 'Add items'),
                            'data-method' => 'post',
                        ]);
                    }
                ],
            ],
        ],
    ]); ?>
    </div>
</div>
