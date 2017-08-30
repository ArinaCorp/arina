<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\accounting\models\AccountingYearSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accounting Years';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounting-year-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Створити запис', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'teacher_id',
            'subject_id',
            'mounth',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
