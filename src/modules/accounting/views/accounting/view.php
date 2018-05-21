<?php

use app\modules\directories\models\position\Position;
use app\modules\directories\models\subject\Subject;
use app\modules\employee\models\CyclicCommission;
use app\modules\students\models\Group;
use yii\bootstrap\Tabs;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\employee\models\Employee */

$this->title =$model->last_name . ' ' . $model->first_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'position_id',
                'value' => function ($model) {
                    return Position::findOne(['id' => $model->position_id])->title;
                }
            ],
            //'category_id',
            //'type',
            'fullName',
            //'last_name',
            //'first_name',
            //'middle_name',
            //'gender',
            [
                'attribute' => 'cyclic_commission_id',
                'value' => function ($model) {
                    return CyclicCommission::findOne(['id' => $model->cyclic_commission_id])->title;
                }
            ],
        ],
    ]) ?>


    <p>
        <?= Html::a('Створити запис', Url::to(['/accounting/accounting-mounth/create', 'teacher_id' => $model->id]), ['class' => 'btn btn-success']) ?>
        <?php // Html::a(Yii::t('app', 'Створити документ Excel'), ['document', 'id' => $model->id], ['class' => 'btn btn-info']) ?>

    </p>
   <?php  Tabs::widget([
       'items' => [
           [
               'label' => Yii::t('app', 'Accounting '),
               'url' => ['/accounting/accounting-mounth'],
           ],
           [
               'label' => Yii::t('app', 'Accounting '),
               'url' => ['/accounting/accounting'],
           ]
       ]
   ]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
            [
                'attribute' => 'group_id',
                'value' => function ($model) {
                    return Group::findOne(['id' => $model->group_id])->title;
                }
            ],
            [
                'attribute' => 'subject_id',
                'value' => function ($model) {
                    return Subject::findOne(['id' => $model->subject_id])->title;
                }
            ],
           // 'teacher_id',
            'date',
            'hours',
            ['class' => 'yii\grid\ActionColumn',
                    'template'=>'{update} {view} ',
                    'buttons'=> [
                            'update'=>function($url, $model, $key){
                                return '<a href="'. Url::to(['/accounting/accounting-mounth/update', 'id' => $model->id]).'"><span class="glyphicon glyphicon-pencil"></span></a>';
                            },
                            /*'delete'=>function($url, $model, $key){
                                return '<a href="'. Url::to(['/accounting/accounting-mounth/delete', 'id' => $model->id]).'"><span class="glyphicon glyphicon-trash"></span></a>';
                            },*/
                            'view'=>function($url, $model, $key){
                                return '<a href="'. Url::to(['/accounting/accounting-mounth/view', 'id' => $model->id]).'"><span class="glyphicon glyphicon-eye-open"></span></a>';
                        },
                    ]
            ]
        ]
    ]) ?>


    </div>
