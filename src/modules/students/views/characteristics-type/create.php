<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\students\models\CharacteristicsType */

$this->title = Yii::t('app', 'Create Characteristics Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Characteristics Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="characteristics-type-create">

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
