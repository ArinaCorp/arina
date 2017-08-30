<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\geo\models\Region */

$this->title = Yii::t('geo', 'Create Region');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Regions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-create">

    <div class="row">
        <div class="col-lg-12">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>         <!-- /.col-lg-12 -->
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
