<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\modules\students\models\CsvImportDocumentItem as DocumentItem;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\CsvImportDocument */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Csv Import Documents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="csv-import-document-view">

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
            'id',
            'file_path',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'data',
                'value' => function (DocumentItem $model) {
                    return $model->data;
                }
            ],
            [
                'attribute' => 'status',
                'value' => function (DocumentItem $model) {
                    return $model->getStatusReadable();
                }
            ],
            [
                'attribute' => 'errors',
                'value' => function (DocumentItem $model) {
                    return $model->errors;
                }
            ],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
