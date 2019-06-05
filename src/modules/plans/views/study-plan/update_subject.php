<?php

use yii\web\View;
use yii\bootstrap\Html;

use app\modules\plans\models\StudyPlan;
use app\modules\plans\widgets\SubjectTable;
use yii\helpers\Url;

/**
 * @var $this View
 * @var $model StudyPlan
 */

$this->title = Yii::t('plans', 'Edit study subject');

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Study plans'), 'url' => ['index']];
?>

<div class="row">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?= $this->render('_form_subject', [
        'model' => $model,
    ]) ?>

</div>