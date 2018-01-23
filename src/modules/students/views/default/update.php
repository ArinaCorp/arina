<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

/* @var $model app\modules\students\models\Student */
/* @var $activeTab integer */

$this->title = Yii::t('app', 'Update student: ') . $model->getShortName();

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

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
        'activeTab' => $activeTab,
    ]) ?>

</div> 