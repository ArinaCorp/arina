<?php

use app\modules\directories\models\subject_cycle\SubjectCycle;
use app\modules\directories\models\subject_cycle\SubjectCycleSearch;
use app\modules\journal\models\evaluation\EvaluationSystem;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel SubjectCycleSearch */
/* @var $dataProvider ActiveDataProvider */
/* @var $model SubjectCycle */

$this->title = Yii::t('app', 'Subject cycles');
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
        <?= Html::a(Yii::t('app', 'Create subject cycle'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            [
                'filter' => EvaluationSystem::getMap('title'),
                'attribute' => 'evaluation_system_id',
                'value' => 'evaluationSystem.title',
            ],
            [
                'filter' => SubjectCycle::getMap('title', 'id', ['parent_id' => SubjectCycle::ROOT_ID]),
                'attribute' => 'parent_id',
                'value' => 'parentCycle.title',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
