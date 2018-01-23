<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Student */
/* @var $activeTab integer */

$this->title = Yii::t('app', 'Create Student');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="student-create">

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