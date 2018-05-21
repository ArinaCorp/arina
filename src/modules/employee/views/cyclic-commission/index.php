<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\employee\models\Employee;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\employee\models\CyclicCommissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cyclic Commissions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cyclic-commission-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?= Html::a(Yii::t('app','Create Cyclic Commission'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
            'headName',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {document} {update} {delete}',
                'buttons'=>[
                    'document' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-list"></span>', $url, [
                            'title' => Yii::t('app', 'List'),
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
