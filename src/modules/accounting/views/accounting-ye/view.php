<?php

use app\modules\directories\models\subject\Subject;
use app\modules\students\models\Group;
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
        <?php //Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /*Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])*/ ?>
    </p>
    <p>
        <?=  Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
           // 'is_in_education',
           // 'position_id',
           // 'category_id',
           // 'type',
            'last_name',
            'first_name',
            'middle_name',

           // 'gender',
          //  'cyclic_commission_id',
           // 'birth_date',
           // 'passport',
         //   'passport_issued_by',
        ],
    ]) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //  'id',
            [
                'attribute' => 'subject_id',
                'value' => function ($model) {
                    return Subject::findOne(['id' => $model->subject_id])->title;
                }
            ],
            // 'teacher_id',
            'mounth',
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {view} ',
                'buttons'=> [
                    'update'=>function($url, $model, $key){
                        return '<a href="'. Url::to(['/accounting/accounting-year/update', 'id' => $model->id]).'"><span class="glyphicon glyphicon-pencil"></span></a>';
                    },
                   /* 'delete'=>function($url, $model, $key){
                        return '<a href="'. Url::to(['/accounting/accounting-mounth/delete', 'id' => $model->id]).'"><span class="glyphicon glyphicon-trash"></span></a>';
                    },*/
                    'view'=>function($url, $model, $key){
                        return '<a href="'. Url::to(['/accounting/accounting-year/view', 'id' => $model->id]).'"><span class="glyphicon glyphicon-eye-open"></span></a>';
                    },
                ]
            ]
        ]
    ]) ?>

</div>
