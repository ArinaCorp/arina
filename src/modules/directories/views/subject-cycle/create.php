<?php

use yii\helpers\Html;
use yii\web\View;

use app\modules\directories\models\subject_cycle\SubjectCycle;

/* @var $this View */
/* @var $model SubjectCycle */

$this->title = Yii::t('app', 'Create subject cycle');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subject cycles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-cycle-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
