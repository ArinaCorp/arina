<?php

use yii\web\View;
use yii\bootstrap\Html;

use app\modules\plans\models\WorkPlan;
use yii\helpers\Url;

/**
 * @var $this View
 * @var $model WorkPlan
 * @var $formView string
 */

$this->title = Yii::t('plans', 'Student plan editing');

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Student plans'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', ['id' => $model->id, 'graph'=>$model->graph]]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render($formView, ['model' => $model]) ?>

</div>