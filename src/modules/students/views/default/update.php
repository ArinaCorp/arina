<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Student */
/* @author VasyaKog */

$this->title = Yii::t('app', 'Update student: ', [
        'modelClass' => 'Student',
    ]) . $model->getShortName();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="student-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsFamily' => $modelsFamily,
        'modelsPhones' => $modelsPhones,
    ]) ?>

</div> 