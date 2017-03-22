<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\students\models\StudentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/* @author VasyaKog */

$this->title = Yii::t('app', 'Students');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="col-lg-8">
        <?= Html::a(Yii::t('app', 'Create Student'), ['update'], ['class' => 'btn btn-success']) ?>
    </div>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'student_code',
            //'sseed_id',
            //'user_id',
            'last_name',
            'first_name',
            'middle_name',

            // 'gender',
            // 'birth_day',
            // 'passport_code',
            // 'tax_id',
            // 'form_of_study_id',
            // 'status',
            // 'created_at',
            // 'updated_at',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div> 