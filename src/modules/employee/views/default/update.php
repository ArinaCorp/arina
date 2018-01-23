<?php

use app\modules\employee\models\Employee;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View
 * @var $model Employee
 * @var $activeTab integer
 */

$this->title = Yii::t('app', 'Update employee:', [
        'modelClass' => 'Employee',
    ]) . ' ' . $model->getFullName();

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getFullName(), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

?>

<div class="employee-update">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'activeTab' => $activeTab,
    ]) ?>

</div>
