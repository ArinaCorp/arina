<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\ExemptionStudentRelation */

$this->title = $model->student->getFullName();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Exemption Student Relations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exemption-student-relation-view">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'student_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->student->link;
                }
            ],
            [
                'attribute' => 'exemption_id',
                'format' => 'raw',
                'value' => function ($model) {
                    /**
                     * @var $model \app\modules\students\models\ExemptionStudentRelation;
                     */
                    return $model->getExemptionTitle();
                }
            ],
            'date_start',
            'date_end',
            'information',
        ],
    ]) ?>

</div>
