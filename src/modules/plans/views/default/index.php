<?php

use yii\web\View;
use yii\helpers\Html;

/**
 * @var $this View
 */

$this->title = Yii::t('plans', 'Plans');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="subject-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-3">
            <p>
                <?= Html::a(Yii::t('plans', 'Create study plan'), ['create-sp'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
    </div>


</div>
