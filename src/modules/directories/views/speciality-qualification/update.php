<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\directories\models\specialityqualification\SpecialityQualification */

$this->title = Yii::t('app', 'Update Speciality Qualification: ') . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Speciality Qualifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="speciality-qualification-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
