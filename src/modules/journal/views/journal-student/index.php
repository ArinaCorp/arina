<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\students\models\Student;
use app\modules\journal\models\record\JournalStudent;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\journal\models\record\JournalStudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'List students');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal-student-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a(Yii::t('app', 'Journal'), ['default/view', 'id' => $load_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Configure list'), ['create', 'load_id' => $load_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'student_id',
                'format' => 'raw',
                'value' => function ($model) {
                    /**
                     * @var $model JournalStudent;
                     */
                    return $model->student->link;
                }
            ],
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    /**
                     * @var $model JournalStudent;
                     */
                    return JournalStudent::getListTypes()[$model->type];
                }
            ],
            'date',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn',
                'template' => "{delete}"],
        ],
    ]); ?>

</div>
