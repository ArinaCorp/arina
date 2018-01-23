<?php

use yii\helpers\Html;
use yii\helpers\Url;
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
 * @var $activeTab integer
 */

$form = ActiveForm::begin([
    'id' => 'employeeForm',
]);


$this->registerJs(<<<JS
var form = jQuery('#employeeForm');
jQuery('.save-btn').on('click', function (e) {
    var btn = jQuery(this);
    form.find('[name="' + btn.data('action') + '"]').prop('disabled', false);
    form.submit();
    e.preventDefault(e);
    return false;
});

var tabs = jQuery('#employeeTabs');
tabs.on('shown.bs.tab', function () {
    var activeTab = tabs.find('li').index(tabs.find('.active'));
    form.find('[name="activeTab"]').val(activeTab);
});

function updateTabsErrors() {
    tabs.find('li').each(function (index, tabEl) {
        var tab = jQuery(tabEl);
        var link = tab.find('a');
        var tabContent = jQuery(link.attr('href'));
        if (tabContent.find('.has-error').length) {
            if (link.find('.fa-warning').length === 0) {
                link.html('<i class="fa fa-warning"></i> ' + link.html());
            }
            link.addClass('tab-error');
        } else {
            link.find('.fa-warning').remove();
            link.removeClass('tab-error');
        }
    });
}

form.on('afterValidate', function () {
    updateTabsErrors();
});

JS
);

?>
<div class="row">
    <div class="col-md-12">
        <p>
            <?php if (!$model->isNewRecord): ?>
                <?= Html::a(FA::icon('eye'), Url::to(['/employee/default/view', 'id' => $model->primaryKey]), [
                    'title' => Yii::t('app', 'View'),
                    'data-toggle' => 'tooltip',
                    'class' => 'btn btn-default cancel-btn'
                ]) ?>
            <?php endif ?>
            <?= Html::a(FA::icon('arrow-left'), Url::to(['/employee/default']), [
                'title' => Yii::t('app', 'Cancel'),
                'class' => 'btn btn-success'
            ]) ?>
            <?= Html::hiddenInput('save', 1, ['disabled' => true]) ?>
            <?= Html::submitButton(FA::icon('save'), [
                'title' => Yii::t('app', 'Save'),
                'data-action' => 'save',
                'class' => 'btn btn-primary save-btn',
            ]) ?>
            <?= Html::hiddenInput('stay', 1, ['disabled' => true]) ?>
            <?= Html::submitButton(FA::icon('floppy-o'), [
                'title' => Yii::t('app', 'Save and stay here'),
                'data-action' => 'stay',
                'class' => 'btn btn-info save-btn',
            ]) ?>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?= Html::hiddenInput('activeTab', $activeTab) ?>
        <?= Tabs::widget([
            'id' => 'employeeTabs',
            'linkOptions' => [
                'data-pjax' => 0,
            ],
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
                        'form' => $form,
                    ]),
                    'active' => $activeTab == 1 ? true : false,
                    'options' => [
                        'id' => 'education'
                    ],
                ],
            ],
            'navType' => 'nav-tabs',
            'itemOptions' => [
                'class' => 'employee-tab'
            ],
            'encodeLabels' => false
        ]) ?>
    </div>
</div>
<?php ActiveForm::end() ?>