<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\employee\models\Employee;
use app\modules\directories\models\position\Position;

/* @var $this yii\web\View */
/* @var $model app\modules\employee\models\CyclicCommission */

$this->title = Yii::t('app', 'Cyclic Commission') . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Cyclic Commissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cyclic-commission-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Get Excel document'), ['document', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) 
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'headName',
        ],
    ]) ?>

    <?=
    /**
     * @var $emp Employee
     */
    \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'last_name',
            'first_name',
            'middle_name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        $customurl = Yii::$app->getUrlManager()->createUrl(['employee/default/view', 'id' => $model['id']]); //$model->id для AR
                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $customurl,
                            ['title' => Yii::t('yii', 'View'), 'data-pjax' => '0']);
                    },
                ],
            ],
        ],
    ]);
    ?>

</div>
