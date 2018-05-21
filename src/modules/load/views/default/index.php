<?php

use app\modules\directories\models\StudyYear;
use app\modules\load\models\LoadSearch;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this View
 * @var $searchModel LoadSearch;
 * @var $dataProvider ActiveDataProvider
 */

$this->title = Yii::t('load', 'Loads');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="load-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('load', 'Create load'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'width: 50px']],

            [
                'attribute' => 'study_year_id',
                'format' => 'raw',
                'value' => function (StudyYear $model, $key, $index, $widget) {
                    return $model->year_start;
                }
            ],
            [
                'header' => Yii::t('app', 'Actions'),
                'class' => ActionColumn::class,
                'contentOptions' => ['style' => 'width: 90px'],
                'template' => '{view} {export}',
                'buttons' => [
                    'export' => function ($url, $model) {
                        $options = [
                            'title' => Yii::t('app', 'Export'),
                        ];
                        $url = Url::toRoute(['load/export', 'id' => $model->id]);
                        return Html::a('<span class="glyphicon glyphicon-file"</span>', $url, $options);
                    }
                ]
            ],
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>
</div>
