<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\students\models\StudentGroup;

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
            'date',
            [
                'attribute' => 'type',
                'value' => function ($model, $index, $widget) {
                    /* @var $model StudentGroup */
                    return $model->getType();
                },
            ],
            [
                'attribute' => 'student_id',
                'value' => function ($model, $index, $widget) {
                    /* @var $model StudentGroup */
                    return $model->student->getFullNameAndCode();
                },
            ],
            [
                'attribute' => 'group_id',
                'value' => function ($model, $index, $widget) {
                    /* @var $model StudentGroup */
                    return $model->group->title;
                },
            ],
            // 'comment',
            // 'funding_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
