<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\students\models\FamilyRelationType */

$this->title = Yii::t('app', 'Create Family Ties Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Family Ties Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="family-ties-type-create">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
