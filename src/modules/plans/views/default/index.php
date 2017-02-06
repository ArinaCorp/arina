<?php

use yii\web\View;
use yii\helpers\Html;

/**
 * @var $this View
 */

$this->title = Yii::t('app', 'Plans');
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


    <p>
        <?= Html::a(Yii::t('app', 'Create work subject'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
