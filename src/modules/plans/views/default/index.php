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
        <div class="col-lg-2">
            <p>
                <?= Html::a(Yii::t('plans', 'View study plans'), ['/plans/study-plan'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="col-lg-3">
            <p>
                <?= Html::a(Yii::t('plans', 'Create study plan'), ['/plans/study-plan/create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="col-lg-2">
            <p>
                <?= Html::a(Yii::t('plans', 'View work plans'), ['/plans/work-plan'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="col-lg-2">
            <p>
                <?= Html::a(Yii::t('plans', 'Create work plan'), ['/plans/work-plan/create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
    </div>


</div>
