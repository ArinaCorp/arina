<?php

use app\modules\employee\models\Employee;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\Alert;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

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

    <div class="row">
        <div class="col-md-12">
            <p>
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

    <div class="row">
    <div class="col-md-12">
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
    </div>
<?php
ActiveForm::end();
Pjax::end();
?>