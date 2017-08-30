<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-index">

    <div class="row">
        <div class="col-lg-12">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>         <!-- /.col-lg-12 -->
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Create City'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'name',
            // 'data:ntext',
            [
                'attribute' => 'district',
                'value' => 'district.name',
                'label' => Yii::t('app', 'District'),
            ],
            [
                'attribute' => 'region',
                'value' => 'region.name',
                'label' => Yii::t('app', 'Region'),
            ],
            [
                'attribute' => 'country',
                'value' => 'country.name',
                'label' => Yii::t('app', 'Country'),
            ],
            // 'createdAt',
            // 'updatedAt',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
