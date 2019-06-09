<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\View;
use yii\data\ActiveDataProvider;

use app\modules\directories\models\subject_relation\SubjectRelation;
use app\modules\directories\models\subject_relation\SubjectRelationSearch;
use app\modules\directories\models\subject_cycle\SubjectCycle;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;

/* @var $this View */
/* @var $searchModel SubjectRelationSearch */
/* @var $dataProvider ActiveDataProvider */
/* @var $model SubjectRelation */

$this->title = Yii::t('app', 'Subject relations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Create subject relation'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'subject',
                'value' => 'subject.title'
            ],
            [
                'filter' => SpecialityQualification::find()->getMap('fullTitle'),
                'attribute' => 'speciality_qualification_id',
                'value' => 'specialityQualification.fullTitle'
            ],
            [
                'filter' => SubjectCycle::find()->getMap('fullTitle'),
                'attribute' => 'subject_cycle_id',
                'value' => 'subjectCycle.fullTitle'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
