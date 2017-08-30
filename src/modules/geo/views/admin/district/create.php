<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\geo\models\District */

$this->title = Yii::t('app', 'Create District');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-create">

    <div class="row">
        <div class="col-lg-12">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>         <!-- /.col-lg-12 -->
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
