<?php

use yii\helpers\Html;
use yii\web\View;

use app\modules\plans\models\WorkSubject;

/**
 * @var $this View
 * @var $model WorkSubject
 */

$this->title = Yii::t('plans', 'Work subject creation');
?>

<div class="row">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_subject', [
        'model' => $model,
    ]) ?>

</div>
