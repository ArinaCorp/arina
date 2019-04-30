<?php

use app\modules\journal\models\evaluation\Evaluation;
use app\modules\journal\models\presence\NotPresenceType;
use app\modules\journal\models\record\JournalMark;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalMark */

$this->title = Yii::t('app', "Mark");
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Journal Marks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal-mark-view">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Journal'), ['default/view', 'id' => $model->journalRecord->load_id], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            [
//                'attribute' => 'student_id',
//                'value' => function ($model) {
//                    /**
//                     * @var $model JournalMark;
//                     */
//                    return $model->student->full
//                },
//            ],
            [
                'attribute' => 'presence',
                'value' => function ($model) {
                    /**
                     * @var $model JournalMark;
                     */
                    return ($model->presence) ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
                },
            ],
            [
                'attribute' => 'not_presence_reason_id',
                'value' => function ($model) {
                    /**
                     * @var $model JournalMark;
                     */
                    if (is_null($model->not_presence_reason_id)) {
                        return null;
                    }
                    return NotPresenceType::getAllList()[$model->not_presence_reason_id];
                },
            ],
            [
                'attribute' => 'evaluation_system_id',
                'value' => function ($model) {
                    /** @var $model JournalMark */
                    if ($model->evaluation_system_id) {
                        return $model->evaluationSystem->title;
                    }
                    return null;
                },
            ],
            [
                'attribute' => 'evaluation_id',
                'value' => function ($model) {
                    /**
                     * @var $model JournalMark;
                     */
                    if (is_null($model->evaluation_id)) {
                        return null;
                    }
                    //@TODO refactor it (used relation)
                    return Evaluation::getListBySystem($model->evaluation_system_id)[$model->evaluation_id];
                },
            ],
            'date',
            [
                'attribute' => 'retake_evaluation_id',
                'value' => function ($model) {
                    /**
                     * @var $model JournalMark;
                     */
                    if (is_null($model->retake_evaluation_id)) {
                        return null;
                    }
                    //@TODO refactor it (used relation)
                    return Evaluation::getListBySystem($model->evaluation_system_id)[$model->retake_evaluation_id];
                },
            ],
            'retake_date',
            'comment:ntext',
        ],
    ]) ?>

</div>
