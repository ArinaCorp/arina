<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Groups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>


    <p>
        <?= Html::a(Yii::t('app', 'Create Group'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'speciality_qualifications_id',
            //'created_study_year_id',
            //'number_group',
            'title',
            [
                'label' => Yii::t('app', 'System title'),
                'value' => function ($model, $key, $index, $widget) {
                    /* @var $model \app\modules\students\models\Group */
                    return $model->getSystemTitle();
                },
            ],

            // 'group_leader_id',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {document} {update} {delete}',
                'buttons'=>[
                    'document' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-list"></span>', $url, [
                            'title' => Yii::t('app', 'List'),
                        ]);
                    },

                ]
            ],
        ],
    ]); ?>

</div>
