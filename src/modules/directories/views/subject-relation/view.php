<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\View;

use app\modules\directories\models\subject_relation\SubjectRelation;

/* @var $this View */
/* @var $model SubjectRelation */

$this->title = Yii::t('app', 'Subject relation') ." " . $model->subject->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subject relations'), 'url' => ['index']];
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
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'subject_id',
                'value' => $model->subject->title,
            ],

            [
                'attribute'=>'speciality_qualification_id',
                'value' => $model->specialityQualification->title,
            ],

            [
                'attribute'=>'subject_cycle_id',
                'value' => $model->subjectCycle->title,
            ],
        ],
    ]) ?>

</div>
