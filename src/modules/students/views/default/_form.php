<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\modules\students\models\FamilyTiesType;
use yii\widgets\MaskedInput;
use app\modules\students\models\Exemption;
use yii\widgets\Pjax;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\Alert;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Student */
/* @var $modelsFamily \app\modules\students\models\FamilyTie[] */
/* @var $modelsPhones \app\modules\students\models\StudentsPhones[] */
/* @var $form \yii\bootstrap\ActiveForm */
/* @author VasyaKog */

Pjax::begin([
    'id' => 'pjax-container',
    'formSelector' => '#student-form',
    'timeout' => 3000,
]);
$form = ActiveForm::begin([
    'id' => 'product-form',
    'enableClientValidation' => false,
]);

if (isset($_COOKIE['active-student-tab'])) {
    $tab = $_COOKIE['active-student-tab'];
    $activeTab = strtr($tab, ['#active-student-tab' => '']);
}


?>
<div class="status-bar row">
    <?php
    echo Html::a(FA::icon('undo'), Yii::$app->user->getReturnUrl(['/shop/product/index']), [
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
    if (!$model->isNewRecord) {
        echo Html::a(FA::icon('trash'), ['/shop/product/delete', 'id' => $model->primaryKey], [
            'title' => Yii::t('app', 'Delete'),
            'data-toggle' => 'tooltip',
            'class' => 'btn btn-danger del-btn',
            'data-method' => 'post',
            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
        ]);
    }
    ?>
    <div class="clearfix"></div>
</div>
<?php
if (Yii::$app->session->hasFlash('save-student')) {
    echo Alert::widget([
        'id' => 'success-alert',
        'type' => 0,
        'body' => Yii::$app->session->getFlash('save-student'),
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
                'label' => Yii::t('app', 'Family'),
                'content' => $this->render('_family', [
                    'model' => $model,
                    'modelsFamily' => $modelsFamily,
                    'form' => $form,
                ]),
                'active' => $activeTab == 1 ? true : false,
                'options' => [
                    'id' => 'family'
                ],
            ],
            [
                'label' => Yii::t('app', 'Contacts'),
                'content' => $this->render('_contacts', [
                    'model' => $model,
                    'modelsPhones' => $modelsPhones,
                    'modelsEmails' => $modelsEmails,
                    'form' => $form,
                ]),
                'active' => $activeTab == 2 ? true : false,
            ],
//            [
//                'label' => Yii::t('app', 'Options'),
//                'content' => $this->render('_options', [
//                    'model' => $model,
//                    'dataProvider' => $optionsDataProvider,
//                    'form' => $form,
//                ]),
//                'active' => $activeTab == 3 ? true : false,
//            ],
//            [
//                'label' => Yii::t('app', 'In stock'),
//                'content' => $this->render('_stock', [
//                    'model' => $model,
//                    'dataProvider' => $inStockDataProvider,
//                    'columns' => $columns,
//                    'total' => $total,
//                    'form' => $form,
//                ]),
//                'active' => $activeTab == 4 ? true : false,
//            ],
//            [
//                'label' => Yii::t('app', 'Images'),
//                'content' => $this->render('_images', [
//                    'model' => $model,
//                    'dataProvider' => $imageDataProvider,
//                    'thumbsDataProvider' => $thumbsDataProvider,
//                    'columns' => $imageColumns,
//                    'form' => $form,
//                ]),
//                'active' => $activeTab == 5 ? true : false,
//            ],
        ],
        'navType' => 'nav-tabs',
        'options' => [
            'class' => 'row'
        ],
        'itemOptions' => [
            'class' => 'student-tab'
        ],
        'encodeLabels' => false
    ]) ?>
</div>
<?php
ActiveForm::end();
Pjax::end();
?>

