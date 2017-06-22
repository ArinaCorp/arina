<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Journal Marks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal-mark-index">

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?= Html::encode($this->title) ?>
        </h1>
    </div>
</div>


    <p>
        <?= Html::a(Yii::t('app', 'Create Journal Mark'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'record_id',
            'student_id',
            'presence',
            'not_presence_reason_id',
            // 'evaluation_system_id',
            // 'evaluation_id',
            // 'date',
            // 'retake_evaluation_id',
            // 'retake_date',
            // 'comment:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
