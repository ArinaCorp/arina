<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalMark */

$this->title = Yii::t('app', 'Update Mark');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Journal Marks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="journal-mark-update">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Journal'), ['default/view', 'id' => $model->journalRecord->load_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
        'type' => $type,
    ]) ?>

</div>
