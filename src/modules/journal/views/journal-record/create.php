<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalRecord */

$this->title = Yii::t('app', 'Create Journal Record');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Journal Records'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal-record-create">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Journal'), ['default/view', 'id' => $model->load_id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
        'type' => $type,
    ]) ?>

</div>
