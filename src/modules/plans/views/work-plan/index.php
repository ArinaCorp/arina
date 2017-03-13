<?php

use yii\web\View;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Url;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */
$this->title = Yii::t('plans', 'Work plans');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-8">
        <?= Html::a(Yii::t('plans', 'Create work plan'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <br/><br/>
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'header' => Yii::t('plans', 'Work plans'),
                'value' => 'title',
                'contentOptions' => ['style'=>'width: 50%'],
            ],
            [
                 'header' => Yii::t('app', 'Study year'),
                 'value' => 'yearTitle'
            ],
            'updated',
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
