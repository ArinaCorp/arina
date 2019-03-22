<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\grid\GridView;
use \app\modules\students\models\CsvImportDocument as Document;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Csv Import Documents');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="csv-import-document-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>


    <p>
        <?= Html::a(Yii::t('app', 'Create Csv Import Document'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'file_path',
                'value' => function (Document $model) {
                    return $model->getShortPath();
                }
            ],
            [
                'attribute' => 'status',
                'value' => function (Document $model) {
                    return $model->getStatusReadable();
                }
            ],
            'created_at:datetime',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{rerun} {view} {delete}',
                'buttons' => [
                    'rerun' => function ($url, Document $model, $key) {
                        if ($model->status === Document::STATUS_ERROR) {
                            return Html::a(FA::icon(FA::_REFRESH), ['rerun', 'id' => $model->id]);
                        }
                        return '';
                    },
                ]
            ]
        ],
    ]); ?>

</div>
