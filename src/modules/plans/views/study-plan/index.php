<?php

use yii\helpers\Html;
use yii\web\View;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;

use app\modules\directories\models\speciality\Speciality;
use app\modules\plans\models\StudyPlanSearch;

/* @var $this View
 * @var $searchModel StudyPlanSearch;
 * @var $dataProvider ActiveDataProvider
 */

$this->title = Yii::t('plans', 'Study plans');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="study-plans-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-8">
        <?= Html::a(Yii::t('app', 'Create study plan'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <br/><br/>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'contentOptions' => ['style' => 'width: 550px'],
                'attribute' => 'speciality_id',
                'value' => function ($model) {
                    return Speciality::findOne(['id' => $model->speciality_id])->title;
                }
            ],
            'updated',
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions'=>[ 'style'=>'width: 80px'],
            ],
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>
</div>