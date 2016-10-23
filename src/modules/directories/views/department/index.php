<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\department\models\DepartmentQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model \app\modules\directories\models\Department */

$this->title = Yii::t('app', 'Departments');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="department-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Department'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'title',
            'head_id',
            [
                'attribute'=>'specialities',
                'format'=>'raw',
                'value'=> function ($model, $key, $index, $widget) {
                    /* @var $model \app\modules\directories\models\Department*/
                    return $model->getSpecialitiesListLinks();
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
