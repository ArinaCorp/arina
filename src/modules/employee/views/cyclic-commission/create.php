<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\employee\models\cyclic_commission\CyclicCommission */

$this->title = 'Create Cyclic Commission';
$this->params['breadcrumbs'][] = ['label' => 'Cyclic Commissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cyclic-commission-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
