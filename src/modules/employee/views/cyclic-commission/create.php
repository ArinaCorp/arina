<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\employee\models\CyclicCommission */

$this->title = Yii::t('app', 'Create Cyclic Commission');
$this->params['breadcrumbs'][] = ['label' => 'Cyclic Commissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cyclic-commission-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?></p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
