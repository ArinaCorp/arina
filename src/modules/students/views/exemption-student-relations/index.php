<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\students\models\ExemptionStudentRelationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Exemptions journal');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exemption-student-relation-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Add record to exemptions journal'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'filter' => false,
            ],
            ['attribute' => 'student_id',
                'format' => 'raw',
                'value' => function ($model, $key, $index, $widget) {
                    /* @var $model \app\modules\students\models\ExemptionStudentRelation */
                    return $model->student->link;
                },
            ],
            [
                'attribute' => 'exemptionTitle',
            ],
            'date_start',
            'date_end',
            // 'information',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}'
            ],
        ],
    ]); ?>

</div>
