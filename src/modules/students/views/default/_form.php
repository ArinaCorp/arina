<?php

use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\modules\students\models\FamilyRelationType;
use yii\widgets\MaskedInput;
use app\modules\students\models\Exemption;
use yii\widgets\Pjax;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\Alert;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\Student */
/* @var $modelsFamily \app\modules\students\models\FamilyRelation[] */
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
<div class="row">
    <div class="col-md-12">
        <p>
            <?php
            if (!$model->isNewRecord) {
                echo Html::a(FA::icon('eye'), \yii\helpers\Url::to(['/students/default/view', 'id' => $model->primaryKey]), [
                    'title' => Yii::t('app', 'View'),
                    'data-toggle' => 'tooltip',
                    'class' => 'btn btn-default cancel-btn'
                ]);
            }
            echo Html::a(FA::icon('undo'), \yii\helpers\Url::to(['/students/default']), [
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
        </p>
    </div>
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
<div class="row">
    <div class="col-md-12">
        <?= Tabs::widget([
            'id' => 'student-tabs',
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
                        'modelsSocials' => $modelsSocials,
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
            'itemOptions' => [
                'class' => 'student-tab'
            ],
            'encodeLabels' => false
        ]) ?>
    </div>
</div>
<?php
ActiveForm::end();
Pjax::end();
?>

