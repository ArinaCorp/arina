<?php

use yii\helpers\Html;
use yii\web\View;
use app\modules\employee\models\Employee;

/* @var $this View 
 * @var $model Employee
 * @var $activeTab integer
 */

$this->title = Yii::t('app', 'Create employee');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="employee-create">

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
