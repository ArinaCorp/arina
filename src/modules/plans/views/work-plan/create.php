<?php

use yii\web\View;
use yii\bootstrap\Html;

use app\modules\plans\models\StudyPlan;

/**
 * @var View $this
 * @var StudyPlan $model
 */
$this->title = Yii::t('plans', 'Create work plan');

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Work plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>