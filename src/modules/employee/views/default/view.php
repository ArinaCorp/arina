<?php

use app\modules\employee\models\Employee;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\View;
use app\modules\directories\models\position\Position;
use app\modules\directories\models\qualification\Qualification;

/* @var $this View
 * @var $model Employee */

$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="employee-view">

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
            [
                'attribute' => 'is_in_education',
                'value' => $model->getIsInEducationName(),
            ],
            [
                'attribute' => 'position_id',
                'value' => function ($model) {
                    return Position::findOne(['id' => $model->position_id])->title;
                }
            ],
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return Qualification::findOne(['id' => $model->category_id])->title;
                }
            ],
            'type',
            'first_name',
            'middle_name',
            'last_name',
            [
                'attribute' => 'gender',
                'value' => $model->getGenderName(),
            ],
            'cyclic_commission_id',
            'birth_date',
            'passport',
            'passport_issued_by',
        ],
    ]) ?>

</div>
