<?php

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
<div class="row">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-8">
        <?= Html::a(Yii::t('app', 'Create study plan'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <br/><br/>

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
                'value'=>function ($model) {
        return Html::a($model->getTitle(), Url::toRoute(['study-plan/view', 'id' => $model->id]));
    },

            ],
            [
                'header' => Yii::t('app', 'Updated'),
                    'value' => 'updatedForm'
            ],
            [
                'header' => Yii::t('app', 'Actions'),
                'class' => ActionColumn::className(),
                'contentOptions' => ['style'=>'width: 90px'],
                'template' => '{view} {update} {export} {delete}',
                'buttons' => [
                    'export' => function ($url, $model) {
                        $options = [
                            'title' => Yii::t('plans', 'Export'),
                        ];
                        $url = Url::toRoute(['study-plan/make-excel', 'id' => $model->id]);
                        return Html::a('<span class="glyphicon glyphicon-file"</span>', $url, $options);
                    }
                ]
            ],
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>
</div>