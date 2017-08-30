<?php

use app\modules\directories\models\subject\Subject;
use app\modules\employee\models\Employee;
use app\modules\students\models\Group;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\accounting\models\AccountingMounth */

$this->title = $model->teacher_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Accounting-Mounths'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounting-mounth-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'List'), Url::to(['/accounting/accounting/view', 'id' => $model->teacher_id]), ['class' => 'btn btn-success']) ?>
        <?= Html::a('Оновити', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Видалити', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'group_id',
                'value' => function ($model) {
                    return Group::findOne(['id' => $model->group_id])->title;
                }
            ],
            [
                'attribute' => 'subject_id',
                'value' => function ($model) {
                    return Subject::findOne(['id' => $model->subject_id])->title;
                }
            ],
             'teacher_id',
            'date',
            'hours',
        ],
    ]) ?>

</div>
