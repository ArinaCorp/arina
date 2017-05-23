<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use yii\data\ActiveDataProvider;

use app\modules\directories\models\subject_relation\SubjectRelation;
use app\modules\directories\models\subject_relation\SubjectRelationSearch;

/* @var $this View */
/* @var $searchModel SubjectRelationSearch */
/* @var $dataProvider ActiveDataProvider */
/* @var $model SubjectRelation */

$this->title = Yii::t('app', 'Subject relations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Create subject relation'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [

                'attribute' => 'subject_id',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->subject->title;
                }
            ],
            [

                'attribute' => 'speciality_qualification_id',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->specialityQualification->title;
                }
            ],
            [

                'attribute' => 'subject_cycle_id',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->subjectCycle->title;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
