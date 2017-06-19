<?php

use yii\web\View;
use yii\bootstrap\Html;

use app\modules\plans\models\WorkPlan;

/**
 * @var $this View
 * @var $model WorkPlan
 */

$this->title = Yii::t('plans', 'Edit work subject');

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Work plans'), 'url' => ['index']];
?>

<div class="row">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_subject', [
        'model' => $model,
    ]) ?>

</div>