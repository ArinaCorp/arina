<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \app\modules\geo\models\Village */

$this->title = Yii::t('app', 'Villages') . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Villages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-view">

    <div class="row">
        <div class="col-lg-12">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>         <!-- /.col-lg-12 -->
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'List'), Url::to('index'), ['class' =>'btn btn-success']) ?>
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
            //'id',
            [
                'attribute' => 'name',
                'value' => $model->name,
            ],
            [
                'attribute' => 'district_id',
                'value' => $model->district->name . ' ' .  Yii::t('app','District'),
            ],
            [
                'attribute' => 'region_id',
                'value' => $model->region->name . ' ' .  Yii::t('app','Region'),
            ],
            [
                'attribute' => 'country_id',
                'value' => $model->country->name,
            ],
            'createdAt:datetime',
            'updatedAt:datetime',
        ],
    ]) ?>

</div>
