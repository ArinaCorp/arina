<?php

use app\modules\plans\models\StudyPlan;
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

$this->title = Yii::t('plans', 'Study plans');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="study-plan-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>
    <p>
        <?= Html::a(Yii::t('plans', 'Create study plan'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'width: 50px']],
            [
                'header' => Yii::t('plans', 'Study plans'),
                'contentOptions' => ['style' => 'width: 750px'],
                'label' => 'title',
                'format' => 'raw',
                'value' => function (StudyPlan $model) {
                    return Html::a($model->getTitle(), Url::toRoute(['study-plan/view', 'id' => $model->id]));
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
                        $url = Url::toRoute(['study-plan/export', 'id' => $model->id]);
                        return Html::a('<span class="glyphicon glyphicon-file"</span>', $url, $options);
                    }
                ]
            ],
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>
</div>