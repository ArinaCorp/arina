<?php

use yii\web\View;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

use app\modules\directories\models\speciality\Speciality;

/**
 * @var View $this
 * @var ActiveDataProvider $dataProvider
 */
$this->title = Yii::t('plans', 'Work plans');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="study-plans-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-8">
        <?= Html::a(Yii::t('plans', 'Create work plan'), ['create'], ['class' => 'btn btn-success']) ?>
        <br/>
    </div>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'header',
                'value' => function ($model) {
                    return $model->speciality->title;
                }
            ],
            [
                 'value' => function ($model) {
                    return $model->study_year->getFullName();
                 }
            ],
            'created',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>
</div>
