<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\modules\directories\models\position\Position;
use app\modules\employee\models\cyclic_commission\CyclicCommission;

/** @var $this yii\web\View
 * @var $model app\modules\employee\models\Employee
 * @var $form ActiveForm
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $searchModel app\modules\employee\models\EmployeeSearch */

$this->title = Yii::t('app', 'Employees');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="employee-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create employee'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'is_in_education'
            [
                'attribute' => 'position_id',
                'value' => function ($model) {
                    return Position::findOne(['id' => $model->position_id])->title;
                }
            ],
            //'category_id',
            //'type',
            'last_name',
            'first_name',
            'middle_name',
            //'gender',
            [
                'attribute' => 'cyclic_commission_id',
                'value' => function ($model) {
                    return CyclicCommission::findOne(['id' => $model->cyclic_commission_id])->title;
                }
            ],
            //'birth_date',
            //'passport',
            //'passport_issued_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
