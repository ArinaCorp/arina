<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\journal\models\record\JournalRecord;

/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalRecord */

$this->title = Yii::t('app', 'Journal Record');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Journal Records'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal-record-view">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Journal'), ['default/view', 'id' => $model->load_id], ['class' => 'btn btn-primary']) ?>
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
                'attribute' => 'teacher_id',
                'value' => function ($model) {
                    /**
                     * @var $model JournalRecord
                     */
                    return $model->teacher->fullName;
                }
            ],
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    /**
                     * @var $model JournalRecord
                     */
                    return $model->typeObj->title;
                }
            ],
            'date',
            'description:ntext',
            'home_work:ntext',
            'number',
            'number_in_day',
            'hours',
            [
                'attribute' => 'audience_id',
                'format' => 'raw',
                'value' => function ($model) {
                    /**
                     * @var $model JournalRecord;
                     */
                    if (is_null($model->audience_id)) {
                        return null;
                    }
                    return $model->audience->getLink();
                }
            ]
        ],
    ]) ?>

</div>
