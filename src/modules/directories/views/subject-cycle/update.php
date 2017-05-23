<?php

use yii\helpers\Html;
use yii\web\View;

use app\modules\directories\models\subject_cycle\SubjectCycle;

/* @var $this View */
/* @var $model SubjectCycle */

$this->title = Yii::t('app', 'Update') ." ". $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subject cycles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="row">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
