<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = Yii::$app->name;
?>
<div class="site-index">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
        <?php foreach ($widgets as $widget){
            echo $widget;
        } ?>
    </div>
</div>
