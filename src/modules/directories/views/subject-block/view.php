<?php

use app\modules\directories\models\subject\Subject;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\View;

/* @var $this View
 * @var $model \app\modules\directories\models\subject_block\SubjectBlock
 */

$this->title = Yii::t('app', 'Subject block');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subject Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="subject-view">

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
            'specialityTitle',
            'course',
            [
                'attribute' => 'created',
                'format' => 'datetime'
            ],
            [
                'attribute' => 'updated',
                'format' => 'datetime'
            ],
        ],
    ]) ?>

    <h3><?= Yii::t('app', 'Subjects') ?></h3>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $model->getSubjectsDetail(),
    ]) ?>

</div>
