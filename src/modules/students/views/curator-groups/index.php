<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\students\models\Group;
use app\modules\students\models\CuratorGroup;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\students\models\CuratorGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Curator Groups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="curator-group-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Curator Group'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'group_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->group->getTitleAndLink();
                }
            ],
            [
                'attribute' => 'teacher_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->teacher->getLink();
                }
            ],
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    return CuratorGroup::getTypesList()[$model->type];
                }
            ],
            //'date',
            ['attribute' => 'created_at',
                'format' => 'raw',
                'value' => function ($model) {
                    return date('d.m.Y', $model->updated_at);
                }
            ],
            // 'updated_at',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]); ?>

</div>
