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

<div class="row">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
