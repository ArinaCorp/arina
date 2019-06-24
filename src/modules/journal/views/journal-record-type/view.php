<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalRecordType */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Journal Record Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal-record-type-view">

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
            'title',
            [
                'attribute' => 'description',
                'value' => function ($model) {
                    return ($model->description) ? Yii::t('app', "Yes") : Yii::t('app', 'No');
                },
            ],
            [
                'attribute' => 'homework',
                'value' => function ($model) {
                    return ($model->homework) ? Yii::t('app', "Yes") : Yii::t('app', 'No');
                },
            ],
            [
                'attribute' => 'audience',
                'value' => function ($model) {
                    return ($model->audience) ? Yii::t('app', "Yes") : Yii::t('app', 'No');
                },
            ],
            [
                'attribute' => 'hours',
                'value' => function ($model) {
                    return ($model->homework) ? Yii::t('app', "Yes") : Yii::t('app', 'No');
                },
            ],
            [
                'attribute' => 'present',
                'value' => function ($model) {
                    return ($model->present) ? Yii::t('app', "Yes") : Yii::t('app', 'No');
                },
            ],
            [
                'attribute' => 'date',
                'value' => function ($model) {
                    return ($model->date) ? Yii::t('app', "Yes") : Yii::t('app', 'No');
                },
            ],
            [
                'attribute' => 'n_pp',
                'value' => function ($model) {
                    return ($model->n_pp) ? Yii::t('app', "Yes") : Yii::t('app', 'No');
                },
            ],
            [
                'attribute' => 'n_in_day',
                'value' => function ($model) {
                    return ($model->n_in_day) ? Yii::t('app', "Yes") : Yii::t('app', 'No');
                },
            ],
            [
                'attribute' => 'ticket',
                'value' => function ($model) {
                    return ($model->ticket) ? Yii::t('app', "Yes") : Yii::t('app', 'No');
                },
            ],
            [
                'attribute' => 'is_report',
                'value' => function ($model) {
                    return ($model->is_report) ? Yii::t('app', "Yes") : Yii::t('app', 'No');
                },
            ],
            [
                'attribute' => 'has_retake',
                'value' => function ($model) {
                    return ($model->has_retake) ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
                },
            ],
            'report_title',
            [
                'attribute' => 'work_type_id',
                'value' => function ($model) {
                    if (is_null($model->work_type_id)) {
                        return null;
                    }
                    return \app\modules\plans\models\WorkSubject::getControlLabelList()[$model->id];
                }
            ],
        ],
    ]) ?>

</div>
