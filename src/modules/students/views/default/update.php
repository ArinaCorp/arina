<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Student */
/* @var $modelsFamily \app\modules\students\models\FamilyRelation[] */
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

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsFamily' => $modelsFamily,
        'modelsPhones' => $modelsPhones,
        'modelsEmails' => $modelsEmails,
        'modelsSocials' => $modelsSocials,
    ]) ?>

</div> 