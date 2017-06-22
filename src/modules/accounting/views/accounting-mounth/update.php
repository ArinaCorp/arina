<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\accounting\models\AccountingMounth */

$this->title = 'Оновити запис: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Accounting Mounths', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="accounting-mounth-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
