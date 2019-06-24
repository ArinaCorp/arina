<?php

use yii\helpers\Html;
use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model \app\modules\plans\models\StudentPlan */
/* @var $formView string Passed from controller, depending on user role */

$this->title = Yii::t('plans', 'Create student plan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student plan'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="students-history-create">

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


    <?= $this->render($formView, [
        'model' => $model,
    ]) ?>

</div>
