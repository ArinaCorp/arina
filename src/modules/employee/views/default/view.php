<?php

use app\modules\directories\models\position\Position;
use app\modules\directories\models\qualification\Qualification;
use app\modules\employee\models\Employee;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this View
 * @var $model Employee
 */

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
                'value' => Position::findOne(['id' => $model->position_id])->title,
            ],
            [
                'attribute' => 'category_id',
                'value' => Qualification::findOne(['id' => $model->category_id])->title,
            ],
            //'type',
            'start_date',
            'first_name',
            'middle_name',
            'last_name',
            [
                'attribute' => 'gender',
                'value' => $model->getGenderName(),
            ],
            [
                'attribute' => 'cyclic_commission_id',
                'value' => function (Employee $model) {
                    return $model->getCyclicCommissionTitle();
                }
            ],
            'birth_date',
            'passport',
            'passport_issued_by',
            'passport_issued_date',
        ],
    ]) ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-users"></i> <?= Yii::t('app', 'Education') ?>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items"><!-- widgetContainer -->
            <?php foreach ($model->education as $index => $modelEducation): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <span class="panel-title-address"><?= Yii::t('app', 'Education') ?>: <?= ($index + 1) ?></span>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?= DetailView::widget([
                            'model' => $modelEducation,
                            'attributes' => [
                                'name_of_institution',
                                'document',
                                'graduation_year',
                                'speciality',
                                'qualification',
                                'education_form',
                            ],
                        ]) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
