<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\StudentGroup */

$this->title = $model->student->getFullNameAndCode() . " " . $model->getType() . " " . $model->group->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-group-view">

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
            'date',
            [
                'attribute' => 'type',
                'value' => $model->getType(),
            ],
            [
                'attribute' => 'group_id',
                'value' => $model->group->title,
            ],
            [
                'attribute' => 'student_id',
                'value' => $model->student->getFullNameAndCode(),
            ],
            'comment',
            'funding_id',
        ],
    ]) ?>

</div>
