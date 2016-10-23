<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\directories\models\SpecialityQualification */

$this->title = Yii::t('app', 'Create Speciality Qualification');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Speciality Qualifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speciality-qualification-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
