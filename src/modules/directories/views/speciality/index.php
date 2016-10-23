<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\directories\models\SpecialitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \app\modules\directories\models\Speciality */

$this->title = Yii::t('app', 'Specialities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speciality-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Speciality'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
            [
                'attribute' => 'department_id',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->department->title;
                }

            ],
            //'department',
            'number',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
