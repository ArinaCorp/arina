<?php

use yii\web\View;
use yii\bootstrap\Html;

use app\modules\plans\models\WorkPlan;
use yii\helpers\Url;

/**
 * @var $this View
 * @var $model WorkPlan
 */

$this->title = Yii::t('plans', 'Work plan editing');

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Work plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', ['id' => $model->id, 'graph'=>$model->graph]]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model]) ?>

    <?= Html::a(Yii::t('plans', 'Add subject'), Url::toRoute(['study-plan/create-subject', 'id' => $model->id]), ['class' => 'btn btn-success']); ?>
    <br/><br/>

</div>