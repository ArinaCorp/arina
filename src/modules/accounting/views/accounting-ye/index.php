<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\employee\models\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Працівники      Облік годин за рік';  //Yii::t('app', 'Employees');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a(Yii::t('app', 'Create Employee'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
           // 'is_in_education',
           // 'position_id',
          //  'category_id',
           // 'type',
            'last_name',
            'first_name',
            'middle_name',
            // 'gender',
            // 'cyclic_commission_id',
            // 'birth_date',
            // 'passport',
            // 'passport_issued_by',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}'
            ],
        ],
    ]); ?>
</div>
