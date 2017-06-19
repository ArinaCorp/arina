<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\accounting\models\AccountingMounth */

$this->title = 'Створити запис';
$this->params['breadcrumbs'][] = ['label' => 'Accounting Mounths', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="accounting-mounth-create">
    <p>
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
    </p>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
