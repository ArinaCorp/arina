<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\students\models\ExemptionStudentRelation */

$this->title = Yii::t('app', 'Add record to exemptions journal');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Exemption Student Relations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="exemption-student-relation-create">

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
