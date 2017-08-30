<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\accounting\models\AccountingYear */

$this->title = 'Create Accounting Year';
$this->params['breadcrumbs'][] = ['label' => 'Accounting Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="accounting-year-create">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
