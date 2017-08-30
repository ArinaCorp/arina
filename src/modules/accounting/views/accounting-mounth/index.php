<?php

use app\modules\directories\models\subject\Subject;
use app\modules\students\models\Group;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\accounting\models\AccountingMounthSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accounting Mounths';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounting-mounth-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Створити запис', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Створити документ Excel'), ['document', 'id' => $model->id], ['class' => 'btn btn-info']) ?>

    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
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
            'date',
            'hours',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
