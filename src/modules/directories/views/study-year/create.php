<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\directories\models\StudyYear */

$this->title = Yii::t('app', 'Create Study Year');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Study Years'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="study-year-create">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
