<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Student */
/* @var $modelsFamily \app\modules\students\models\FamilyTie[] */
/* @author VasyaKog */
if (!$model->isNewRecord) {
    $this->title = Yii::t('app', 'Update student: ', [
            'modelClass' => 'Student',
        ]) . $model->getShortName();
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = Yii::t('app', 'Update');
} else {
    $this->title = Yii::t('app', 'Create student', [
        'modelClass' => 'Student',
    ]);
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['Create', 'id' => $model->id]];
}
?>
<div class="student-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsFamily' => $modelsFamily,
        'modelsPhones' => $modelsPhones,
        'modelsEmails' => $modelsEmails,
        'modelsSocials' => $modelsSocials,
    ]) ?>

</div> 