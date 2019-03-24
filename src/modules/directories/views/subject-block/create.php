<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this View
 * @var $model \app\modules\directories\models\subject_block\SubjectBlock */

$this->title = Yii::t('app', 'Create Subject Block');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subject Blocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="subject-create">

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
