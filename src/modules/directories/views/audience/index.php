<?php

use app\modules\directories\models\audience\Audience;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\directories\models\audience\Audience */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Audiences');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audience-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Audience'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'number',
            'name',
            [
                'filter' => Audience::getTypeList(),
                'attribute' => 'type',
                'value' => 'typeTitle',
            ],
            'teacherName',
            'capacity',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
