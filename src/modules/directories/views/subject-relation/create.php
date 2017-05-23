<?php

use yii\helpers\Html;
use yii\web\View;

use app\modules\directories\models\subject_relation\SubjectRelation;


/* @var $this View */
/* @var $model SubjectRelation */

$this->title = Yii::t('app', 'Create subject relation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subject relations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
