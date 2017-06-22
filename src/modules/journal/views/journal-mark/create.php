<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalMark */

$this->title = Yii::t('app', 'Create Journal Mark');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Journal Marks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal-mark-create">

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
