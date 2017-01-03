<?php

use yii\helpers\Html;
use yii\web\View;
use app\modules\employee\models\Employee;

/* @var $this View
 * @var $model Employee */

$this->title = Yii::t('app', 'Update employee:', [
        'modelClass' => 'Employee',
    ]) . ' ' . $model->getFullName();

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getFullName(), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

/**
 * This is the model class for table "employee".
 * @property integer id
 * @property integer is_in_education
 * @property integer position_id
 * @property integer category_id
 * @property integer type
 * @property string first_name
 * @property string middle_name
 * @property string last_name
 * @property integer gender
 * @property integer cyclic_commission_id
 * @property string birth_date
 * @property string passport
 * @property string passport_issued_by
 */
?>

<div class="employee-update">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
