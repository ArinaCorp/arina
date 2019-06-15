<?php

use app\helpers\GlobalHelper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\accounting\models\YearlyHourAccounting */
/* @var $loads \app\modules\load\models\Load[] */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Yearly Hour Accountings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$actionUrl = Url::to(['yearly-hour-accounting/set-month-hour']);
$recordIds = json_encode(ArrayHelper::getColumn($model->hourAccountingRecords, 'id'));

$this->registerJs(<<<JS
function getTotal(selector) {
    let inputs = jQuery(selector);
    let total = 0;
    inputs.each(function () {
        total += parseInt(jQuery(this).val());
    });
    return total;
}

function processPerYearHours(recordId) {
    let total = getTotal("input[name='hours'][data-record-id=" + recordId + "]");
    let perPlanTotal = jQuery("input[name='perPlanTotal'][data-record-id=" + recordId + "]").val();

    jQuery("input[name='total'][data-record-id=" + recordId + "]").val(total);
    jQuery("input[name='incompleteHours'][data-record-id=" + recordId + "]").val(perPlanTotal - total);
    jQuery("input[name='excessiveHours'][data-record-id=" + recordId + "]").val(total - perPlanTotal);
}

function processPerMonthHours(monthIndex) {
    let total = getTotal("input[name='hours'][data-month-index=" + monthIndex + "]");
    jQuery("input[name='perMonthTotal'][data-month-index=" + monthIndex + "]").val(total);
}

function processPerYearTotal(recordId) {
    let total = parseInt(jQuery("input[name='total'][data-record-id=" + recordId + "]").val());
    let controlHours = parseInt(jQuery("input[name='controlHours'][data-record-id=" + recordId + "]").val());
    jQuery("input[name='perYearTotal'][data-record-id=" + recordId + "]").val(total + controlHours);

    let sumYearTotals = getTotal("input[name='perYearTotal']");
    jQuery("input[name='sumYearTotals']").val(sumYearTotals);
}

function processSumTotals() {
    let sumMonthTotal = getTotal("input[name='perMonthTotal']");
    let sumHourTotals = getTotal("input[name='total']");

    console.log('###############################');
    console.log('sumMonthTotal', sumMonthTotal);
    console.log('sumHourTotals', sumHourTotals);

    if (sumMonthTotal === sumHourTotals) {
        jQuery("input[name='sumHourTotals']").val(sumHourTotals);
    }

    let sumPlanTotals = jQuery("input[name='sumPlanTotals']").val();
    jQuery("input[name='sumIncompleteHours']").val(sumPlanTotals - sumHourTotals);
    jQuery("input[name='sumExcessiveHours']").val(sumHourTotals - sumPlanTotals);
}

jQuery('document').ready(function () {
    let recordIds = $recordIds;

    recordIds.forEach((recordId) => {
        processPerYearHours(recordId);
        processPerYearTotal(recordId);
    });

    for (let monthIndex = 0; monthIndex < 12; monthIndex++) {
        processPerMonthHours(monthIndex);
    }
    
    processSumTotals();
});

jQuery("input[name='hours']").on('change', function () {
    let recordId = jQuery(this).data('recordId');
    let monthIndex = jQuery(this).data('monthIndex');

    jQuery.ajax({
        url: '$actionUrl'.addUrlParam('recordId', recordId).addUrlParam('monthIndex', monthIndex),
        type: 'POST',
        data: {
            'monthHour': jQuery(this).val()
        },
        success: function (res) {
            if (res) {
                jQuery.notify({
                    "icon": "glyphicon glyphicon-info-sign",
                    "title": '',
                    "message": res.message,
                }, {
                    "type": "info",
                    "allow_dismiss": true,
                    "newest_on_top": true,
                    "placement": {"from": "top", "align": "right"},
                    "delay": "500"
                })
            }
        }
    });

    processPerYearHours(recordId);
    processPerYearTotal(recordId);
    processPerMonthHours(monthIndex);
    
    processSumTotals();
});

jQuery("input[name='controlHours']").on('change', function () {
    let recordId = jQuery(this).data('recordId');
    processPerYearTotal(recordId);
});
JS
);
?>

<div class="yearly-hour-accounting-view">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'studyYear.title',
            'teacher.fullName',
            'created_at:datetime',
        ],
    ]); ?>

    <table class="table table-condensed table-bordered table-hover">
        <tbody>
        <tr>
            <th>Курс</th>
            <?php foreach ($loads as $load): ?>
                <td>
                    <?= $load->group->getCourse($model->study_year_id) ?>
                </td>
            <?php endforeach ?>
        </tr>
        <tr>
            <th>Групи</th>
            <?php foreach ($loads as $load): ?>
                <td>
                    <?= $load->group->getSystemTitle() ?>
                </td>
            <?php endforeach ?>
        </tr>
        <tr>
            <th>Предмет</th>
            <?php foreach ($loads as $load): ?>
                <td>
                    <?= $load->workSubject->subject->short_name ?>
                </td>
            <?php endforeach ?>
        </tr>
        <?php $monthIndex = 0; ?>
        <?php foreach (GlobalHelper::getWeeksByMonths() as $month => $_): ?>
            <tr>
                <td><?= Yii::t('app', $month) ?></td>
                <?php foreach ($model->hourAccountingRecords as $record): ?>
                    <td>
                        <?= Html::input('number', 'hours', $record->hours_per_month[$monthIndex], [
                            'class' => 'form-control no-spinner',
                            'data-record-id' => $record->id,
                            'data-month-index' => $monthIndex,
                            'min' => 0
                        ]) ?>
                    </td>
                <?php endforeach ?>
                <td>
                    <?= Html::input('number', 'perMonthTotal', 0, [
                        'class' => 'form-control',
                        'readOnly' => true,
                        'data-month-index' => $monthIndex,
                    ]) ?>
                </td>
            </tr>
            <?php $monthIndex++ ?>
        <?php endforeach ?>

        <tr>
            <td>Всього годин</td>
            <?php foreach ($model->hourAccountingRecords as $record): ?>
                <td>
                    <?= Html::input('number', 'total', 0, [
                        'class' => 'form-control',
                        'readOnly' => true,
                        'data-record-id' => $record->id,
                    ]) ?>
                </td>
            <?php endforeach ?>
            <td>
                <?= Html::input('number', 'sumHourTotals', 0, [
                    'class' => 'form-control',
                    'readOnly' => true
                ]) ?>
            </td>
        </tr>

        <tr>
            <td>Всього годин по плану</td>
            <?php $sumPlanTotals = 0; ?>
            <?php foreach ($model->hourAccountingRecords as $record): ?>
                <td>
                    <?= Html::input('number', 'perPlanTotal', $record->load->getPlanTotal(), [
                        'class' => 'form-control',
                        'readOnly' => true,
                        'data-record-id' => $record->id,
                    ]) ?>
                </td>
                <?php $sumPlanTotals+=$record->load->getPlanTotal() ?>
            <?php endforeach ?>
            <td>
                <?= Html::input('number', 'sumPlanTotals', $sumPlanTotals, [
                    'class' => 'form-control',
                    'readOnly' => true
                ]) ?>
            </td>
        </tr>

        <tr>
            <td>Не виконано годин</td>
            <?php foreach ($model->hourAccountingRecords as $record): ?>
                <td>
                    <?= Html::input('number', 'incompleteHours', 0, [
                        'class' => 'form-control',
                        'readOnly' => true,
                        'data-record-id' => $record->id,
                    ]) ?>
                </td>
            <?php endforeach ?>
            <td>
                <?= Html::input('number', 'sumIncompleteHours', 0, [
                    'class' => 'form-control',
                    'readOnly' => true
                ]) ?>
            </td>
        </tr>

        <tr>
            <td>Дано годин понад план</td>
            <?php foreach ($model->hourAccountingRecords as $record): ?>
                <td>
                    <?= Html::input('number', 'excessiveHours', 0, [
                        'class' => 'form-control',
                        'readOnly' => true,
                        'data-record-id' => $record->id,
                    ]) ?>
                </td>
            <?php endforeach ?>
            <td>
                <?= Html::input('number', 'sumExcessiveHours', 0, [
                    'class' => 'form-control',
                    'readOnly' => true
                ]) ?>
            </td>
        </tr>

        <tr>
            <td>Екзамени, заліки</td>
            <?php foreach ($model->hourAccountingRecords as $record): ?>
                <td>
                    <?= Html::input('number', 'controlHours', 0, [
                        'class' => 'form-control',
                        'data-record-id' => $record->id,
                        'min' => 0
                    ]) ?>
                </td>
            <?php endforeach ?>
        </tr>

        <tr>
            <td>Всього дано за рік годин</td>
            <?php foreach ($model->hourAccountingRecords as $record): ?>
                <td>
                    <?= Html::input('number', 'perYearTotal', 0, [
                        'class' => 'form-control',
                        'readOnly' => true,
                        'data-record-id' => $record->id,
                    ]) ?>
                </td>
            <?php endforeach ?>
            <td>
                <?= Html::input('number', 'sumYearTotals', 0, [
                    'class' => 'form-control',
                    'readOnly' => true
                ]) ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>
