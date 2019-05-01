<?php

use app\modules\plans\models\WorkPlan;
use yii\helpers\Html;
use yii\web\View;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Url;

use app\modules\plans\models\StudyPlanSearch;

/* @var $this View
 * @var $searchModel StudyPlanSearch;
 * @var $dataProvider ActiveDataProvider
 */

$this->title = Yii::t('plans', 'Work plans');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-plan-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('plans', 'Create work plan'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'width: 50px']],
            [
                'header' => Yii::t('plans', 'Work plans'),
                'contentOptions' => ['style' => 'width: 750px'],
                'label' => 'title',
                'format' => 'raw',
                'value' => function (WorkPlan $model) {
                    return $model->getTitle();
                },
            ],
            [
                'attribute' => 'updated',
                'format'=>'datetime'
            ],
            [
                'attribute' => 'created',
                'format'=>'datetime'
            ],
            [
                'header' => Yii::t('app', 'Actions'),
                'class' => ActionColumn::class,
                'contentOptions' => ['style' => 'width: 90px'],
                'template' => '{view} {update} {export} {delete}',
                'buttons' => [
                    'export' => function ($url, $model) {
                        $options = [
                            'title' => Yii::t('plans', 'Export'),
                        ];
                        $url = Url::toRoute(['work-plan/export', 'id' => $model->id]);
                        return Html::a('<span class="glyphicon glyphicon-file"</span>', $url, $options);
                    }
                ]
            ],
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>
</div>