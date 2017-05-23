<?php

use yii\helpers\Html;
use yii\web\View;

use app\modules\directories\models\subject_relation\SubjectRelation;

/* @var $this View */
/* @var $model SubjectRelation */

$this->title = Yii::t('app', 'Update subject relation') .":". $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subject relations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="subject-relation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
