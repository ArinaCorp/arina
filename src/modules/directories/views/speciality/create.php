<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\directories\models\speciality\Speciality */

$this->title = Yii::t('app', 'Create Speciality');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Specialities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speciality-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
