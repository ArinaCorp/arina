<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\rbac\models\ActionAccess */

$this->title = Yii::t('rbac', 'Create Action Access');
$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac', 'Action Accesses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="action-access-create">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('rbac', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
