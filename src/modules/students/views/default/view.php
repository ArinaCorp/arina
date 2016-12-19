<?php


use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Student */
/* @author VasyaKog */

$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-md-2 col-md-offset-5">
            <?= $model->getPhoto(); ?>
        </div>
    </div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'student_code',
            'sseed_id',
            'last_name',
            'first_name',
            'middle_name',
            [
                'attribute' => 'gender',
                'value' => $model->getGenderName(),
            ],
            'birth_day',
            'passport_code',
            'passport_issued',
            'passport_issued_date',
            'tax_id',
            [
                'attribute' => 'created_at',
                'value' => date('H:m d.m.y', $model->created_at),
            ],
            [
                'attribute' => 'updated_at',
                'value' => date('H:m d.m.Y', $model->updated_at),
            ],
            [
                'label' => Yii::t('app', 'Group now'),
                'format' => 'raw',
                'value' => $model->getGroupLinksList(),
            ],
        ],
    ]) ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-users"></i> <?= Yii::t('app', 'Family') ?>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items"><!-- widgetContainer -->
            <?php foreach ($model->family as $index => $modelFamily): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <span class="panel-title-address"><?= Yii::t('app', 'Family tie') ?>: <?= ($index + 1) ?></span>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?= DetailView::widget([
                            'model' => $modelFamily,
                            'attributes' => [
                                'last_name',
                                'first_name',
                                'middle_name',
                                'phone1',
                                'phone2',
                                'email',
                                'work_place',
                                'work_position',
                            ],
                        ]) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div> 