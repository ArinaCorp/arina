<?php

use yii\helpers\Html;
use yii\web\View;

use app\modules\plans\models\StudySubject;

/**
 * @var $this View
 * @var $model StudySubject
 */

$this->title = Yii::t('plans', 'Study subject adding');
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
