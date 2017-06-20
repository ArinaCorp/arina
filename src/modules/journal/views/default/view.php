<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \app\modules\load\models\Load */

$this->title = $model->getLabelInfo();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Journal Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'List'), ['/journal/journal-student', 'load_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>


</div>