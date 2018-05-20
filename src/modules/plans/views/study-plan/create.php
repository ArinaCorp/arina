<?php

use yii\helpers\Html;
use yii\web\View;

use app\modules\plans\models\StudyPlan;

/**
 * @var $this View
 * @var $model StudyPlan
 */

$this->title = Yii::t('plans', 'Study plan creating');

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Study plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="study-plan-create">

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
