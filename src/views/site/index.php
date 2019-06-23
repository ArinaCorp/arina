<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $role string */
$this->title = Yii::$app->name;
?>
<div class="site-index">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
        <?php
        Pjax::begin();
        if ($role) {
            echo $this->render('dashboard/_' . $role);
        }
        Pjax::end();
        ?>
    </div>
</div>
