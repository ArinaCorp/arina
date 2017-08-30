<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\evaluation\Evaluation */

$this->title = Yii::t('app', 'Create Evaluation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Evaluations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="evaluation-create">

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
