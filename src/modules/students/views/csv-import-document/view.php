<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use app\modules\students\models\CsvImportDocument as Document;
use app\modules\students\models\CsvImportDocumentItem as DocumentItem;
use app\helpers\GridHelper;

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
        ],
    ]) ?>

    <?php
    $removeUrlTemplate = yii\helpers\Url::to([
        'csv-import-document/delete-multiple-items',
        'ids' => 'DOCUMENT_ITEM_IDS',
    ]);


    $this->registerJs(<<<JS
    var removeUrl = "$removeUrlTemplate";

    var removeBtn = jQuery('#removeBtn');
    
    var onChange = function (e) {
        var activeItems = $('#grid').yiiGridView('getSelectedRows');
        if (activeItems.length) {
            removeBtn.show();
            removeBtn.attr('href', removeUrl.replace('DOCUMENT_ITEM_IDS', activeItems.join(',')));
        } else {
            removeBtn.hide();
        }
    };
    
    jQuery('.documentItemCheckbox').on('change', onChange);
    jQuery('.select-on-check-all').on('change', onChange);

JS
    )
    ?>

    <p>
        <?= Html::a(Yii::t('documents', 'Delete selected'), [''], [
            'id' => 'removeBtn',
            'class' => 'btn btn-danger',
            'style' => 'display:none',
            'data-method' => 'post',
        ]) ?>
    </p>

    <?= GridView::widget([
        'id' => 'grid',
        'dataProvider' => $dataProvider,
        'columns' => array_merge([
            [
                'class' => CheckboxColumn::class,
                'checkboxOptions' => [
                    'class' => 'documentItemCheckbox'
                ],
            ],
            ['class' => 'yii\grid\SerialColumn'],

            'id',
        ],
            GridHelper::getItemColumns(),
            [
                [
                    'attribute' => 'status',
                    'value' => function (DocumentItem $model) {
                        return $model->getStatusReadable();
                    }
                ],
                [
                    'attribute' => 'errors',
                    'value' => function (DocumentItem $model) {
                        $errors = unserialize($model->errors);

                        $result = '';
                        if (is_array($errors)) {
                            foreach ($errors as $error) {
                                $result .= implode(' ', $error);
                            }
                        }

                        return $result;
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function ($url, DocumentItem $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-item', 'id' => $model->id], [
                                'class' => '',
                                'data' => [
                                    'confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.',
                                    'method' => 'post',
                                ],
                            ]);
                        },
                    ]
                ],
            ]
        )
    ]); ?>

</div>
