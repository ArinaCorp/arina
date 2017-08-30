<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\journal\models\record\JournalRecordTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Journal Records');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal-record-index">

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?= Html::encode($this->title) ?>
        </h1>
    </div>
</div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Journal Record'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'load_id',
            'teacher_id',
            'type',
            'date',
            // 'description:ntext',
            // 'home_work:ntext',
            // 'number',
            // 'number_in_day',
            // 'hours',
            // 'audience_id',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
