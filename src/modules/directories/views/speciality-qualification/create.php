<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\directories\models\speciality_qualification\SpecialityQualification */

$this->title = Yii::t('app', 'Create Speciality Qualification');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Speciality Qualifications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speciality-qualification-create">

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
