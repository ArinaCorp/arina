<?php

use yii\helpers\Html;
use yii\widgets\MaskedInput;
use yii\web\View;
use app\modules\employee\models\Employee;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use app\modules\directories\models\position\Position;
use app\modules\directories\models\qualification\Qualification;
use app\modules\employee\models\cyclic_commission\CyclicCommission;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\Pjax;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\Alert;
use yii\bootstrap\Tabs;

/* @var $this View
 * @var $model Employee
 * @var $form \yii\widgets\ActiveForm
 * @var $modelsEducation \app\modules\employee\models\EmployeeEducation[]
 */



Pjax::begin([
    'id' => 'pjax-container',
    'formSelector' => '#employee-form',
    'timeout' => 3000,
]);
$form = ActiveForm::begin([
    'id' => 'product-form',
    'enableClientValidation' => false,
]);

if (isset($_COOKIE['active-employee-tab'])) {
    $tab = $_COOKIE['active-employee-tab'];
    $activeTab = strtr($tab, ['#active-employee-tab' => '']);
}


?>
<div class="status-bar row">
    <?php
    echo Html::a(FA::icon('undo'), Yii::$app->user->getReturnUrl(['/employee']), [
        'title' => Yii::t('app', 'Cancel'),
        'data-toggle' => 'tooltip',
        'class' => 'btn btn-default cancel-btn'
    ]);
    echo Html::button(FA::icon('save'), [
        'title' => Yii::t('app', 'Save'),
        'data-toggle' => 'tooltip',
        'class' => 'btn btn-primary save-btn',
    ]);
    echo Html::button(FA::icon('floppy-o'), [
        'title' => Yii::t('app', 'Save and stay here'),
        'data-toggle' => 'tooltip',
        'data-action' => 'stay',
        'class' => 'btn btn-info save-btn',
    ]);
    ?>
    <div class="clearfix"></div>
</div>
<?php
if (Yii::$app->session->hasFlash('save-employee')) {
    echo Alert::widget([
        'id' => 'success-alert',
        'type' => 0,
        'body' => Yii::$app->session->getFlash('save-employee'),
        'closeButton' => [],
        'delay' => 1000
    ]);
}
?>
<?= $form->errorSummary($model) ?>
<div class="row product-card">
    <?= Tabs::widget([
        'id' => 'product-tabs',
        'items' => [
            [
                'label' => Yii::t('app', 'General'),
                'content' =>
                    $this->render('_main', [
                        'model' => $model,
                        'form' => $form,
                    ]),
                'active' => $activeTab == 0 ? true : false,
                'options' => [
                    'id' => 'general'
                ],
            ],
            [
                'label' => Yii::t('app', 'Education'),
                'content' => $this->render('_education', [
                    'model' => $model,
                    'modelsEducation' => $modelsEducation,
                    'form' => $form,
                ]),
                'active' => $activeTab == 1 ? true : false,
                'options' => [
                    'id' => 'education'
                ],
            ],
        ],
        'navType' => 'nav-tabs',
        'options' => [
            'class' => 'row'
        ],
        'itemOptions' => [
            'class' => 'employee-tab'
        ],
        'encodeLabels' => false
    ]) ?>
</div>
<?php
ActiveForm::end();
Pjax::end();
?>
