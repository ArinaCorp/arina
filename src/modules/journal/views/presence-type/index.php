<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\journal\models\presence\NotPresenceType;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\journal\models\presence\NotPresenceTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Not Presence Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="not-presence-type-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Not Presence Type'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'label',
            [
                'attribute' => 'is_great',
                'value' => function ($model) {
                    return $model->greatLabel;
                },
                'filter' => NotPresenceType::getGreatList(),
            ],
            'percent_hours',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
