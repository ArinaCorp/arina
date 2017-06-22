<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalRecordType */

$this->title = Yii::t('app', 'Create Journal Record Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Journal Record Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal-record-type-create">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Journal page'), ['default/view', 'id' => $model->load_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_form-first', [
        'model' => $model,
    ]) ?>

</div>
