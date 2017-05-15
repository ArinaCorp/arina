<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\students\models\StudentsHistory;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Group */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-view">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Get list group Excel document'), ['document', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php
    $mainAttributes = [
        [
            'label' => Yii::t('app', 'Speciality'),
            'value' => $model->specialityQualification->speciality->title,
        ],
        [
            'attribute' => 'speciality_qualifications_id',
            'value' => $model->specialityQualification->title,
        ],
        [
            'attribute' => 'created_study_year_id',
            'value' => $model->studyYear->getFullName(),
        ],
        'number_group',
        [
            'attribute' => 'systemTitle',
        ],
        'title',
        [
            'attribute' => 'group_leader_id',
            'format' => 'raw',
            'value' => $model->getGroupLeaderLink(),
        ],
        [
            'attribute' => 'curator_id',
            'format' => 'raw',
            'value' => $model->getCuratorLink(),
        ]
    ];
    $financeAttributes = [];
    foreach (StudentsHistory::getPayments() as $key => $value) {
        $financeAttributes[] = [
            'label' => $value,
            'format' => 'raw',
            'value' => $model->getCountByPayment($key),
        ];
    }
    $attributes = \yii\helpers\ArrayHelper::merge($mainAttributes, $financeAttributes);
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'student_code',
            //'sseed_id',
            //'user_id',
            'last_name',
            'first_name',
            'middle_name',
            'paymentTypeLabel',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        $customurl = Yii::$app->getUrlManager()->createUrl(['students/default/view', 'id' => $model['id']]); //$model->id для AR
                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $customurl,
                            ['title' => Yii::t('yii', 'View'), 'data-pjax' => '0']);
                    },
                ],
            ],
        ],
    ]);
    ?>

</div>
