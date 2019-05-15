<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/** @var $this yii\web\View
 * @var $model app\modules\directories\models\position\Position
 * @var $form ActiveForm
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $searchModel \app\modules\directories\models\position\PositionSearch */

$this->title = Yii::t('app', 'Positions');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="position-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Position'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'max_hours_1',
            'max_hours_2',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
