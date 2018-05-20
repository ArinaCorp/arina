<?php

use yii\helpers\Html;
use yii\web\View;

use app\modules\plans\models\WorkPlan;

/**
 * @var $this View
 * @var $model WorkPlan
 */

$this->title = Yii::t('plans', 'Work plan creating');

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Work plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="work-plan-create">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

