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

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_subject', [
        'model' => $model,
    ]) ?>

</div>
