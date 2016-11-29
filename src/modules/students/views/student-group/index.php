<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Student Groups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-group-index">

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?= Html::encode($this->title) ?>
        </h1>
    </div>
</div>


    <p>
        <?= Html::a(Yii::t('app', 'Create Student Group'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'string',
            'type',
            'group_id',
            'student_id',
            // 'comment',
            // 'funding_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
