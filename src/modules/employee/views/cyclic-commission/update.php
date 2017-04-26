<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\employee\models\cyclic_commission\CyclicCommission */

$this->title = Yii::t('app', 'Update Cyclic Commission: ') . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Cyclic Commissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cyclic-commission-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?></p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
