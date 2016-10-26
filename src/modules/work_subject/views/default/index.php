<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\web\View;
use app\modules\work_subject\models\WorkSubjectSearch;
use yii\data\ActiveDataProvider;

/* @var $this View
 * @var $searchModel WorkSubjectSearch
 * @var $dataProvider ActiveDataProvider */

$this->title = Yii::t('app', 'Work subjects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-subject-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="col-lg-8">
        <?= Html::a(Yii::t('app', 'Create work subject'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'plan_id',
            'subject_id',
            'first_name',
            'middle_name',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div> 