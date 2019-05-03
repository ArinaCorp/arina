<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use app\modules\plans\widgets\SubjectTable;
use app\modules\plans\models\StudySubject;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $model StudySubject
 * @var $this SubjectTable
 * @var $dataProvider ActiveDataProvider
 */
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'attribute' => 'subject_id',
            'value' => function ($model) {
                return $model->subject->title;
            }
        ],
        'total',
        'classes',
        'lectures',
        'lab_works',
        'practices',
        'selfWork',
        //'testSemesters',
        //'examSemesters',
        'workSemesters',
        'projectSemesters',
        [ 'header' => '1', 'value' => function ($model) { return $model->weeks[0]; }],
        [ 'header' => '2', 'value' => function ($model) { return $model->weeks[1]; }],
        [ 'header' => '3', 'value' => function ($model) { return $model->weeks[2]; }],
        [ 'header' => '4', 'value' => function ($model) { return $model->weeks[3]; }],
        [ 'header' => '5', 'value' => function ($model) { return $model->weeks[4]; }],
        [ 'header' => '6', 'value' => function ($model) { return $model->weeks[5]; }],
        [ 'header' => '7', 'value' => function ($model) { return $model->weeks[6]; }],
        [ 'header' => '8', 'value' => function ($model) { return $model->weeks[7]; }],
        [
            'class' => ActionColumn::class,
            'header' => Yii::t('app', 'Actions'),
            'contentOptions' => ['style' => 'width: 20px'],
            'template' => '{update} {delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    $options = [
                        'title' => Yii::t('app', 'Update'),
                        'data-pjax' => '0',
                    ];
                    $url = Url::toRoute(['study-plan/update-subject', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"</span>', $url, $options);
                },
                'delete' => function ($url, $model) {
                    $options = [
                        'title' => Yii::t('app', 'Delete'),
                        'data-pjax' => '0',
                    ];
                    $url = Url::toRoute(['study-plan/delete-subject', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                }
            ],
        ]
    ],
]);
?>