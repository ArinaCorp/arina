<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\students\models\Student;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\students\models\StudentsHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Students History');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="students-history-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Students History'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'student_id',
                'value' => function ($model) {
                    return Student::findOne(['id' => $model->student_id])->fullNameAndBirthDate;
                }
            ],
            'date',
            [
                'attribute' => 'information',
                'format' => 'raw',
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
            ],
        ]
    ]); ?>

</div>
