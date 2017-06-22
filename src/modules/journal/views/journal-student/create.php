<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalStudent */

$this->title = Yii::t('app', 'Configurator list');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Journal Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal-student-create">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'List configurations'), ['index', 'load_id' => $model->load_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
