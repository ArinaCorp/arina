<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 30.04.2019
 * Time: 13:31
 */

use app\modules\journal\helpers\JournalHtmlHelper;
use app\modules\journal\models\record\JournalMark;
use app\modules\journal\models\record\JournalRecord;
use app\modules\load\models\Load;
use app\modules\plans\models\WorkPlan;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var bool $isTeacher
 * @var array $loads
 * @var Load $load
 * @var JournalRecord $record
 * @var JournalRecord[] $records
 * @var JournalMark[] $marks
 */

$this->title = Yii::t('app', 'Marks accounting');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$actionUrl = Url::to(['marks-accounting/index']);

$js = '';

$js .= <<<JS
    jQuery('#load_select').on('change', function(){
        jQuery.pjax.reload({
            container: '#marks-accounting-widget', 
            url: '$actionUrl', 
            data: {
                load_id: $(this).val()
            },
            replaceRedirect: false,
            timeout: 999999,
        })
    });
    jQuery('body').on('submit', '#recordCreateFrom', function(){
        jQuery('#recordCreateModal').modal('hide');
    });
JS;


$actionCreateMarkUrl = Url::to(['marks-accounting/create-mark']);
$actionUpdateMarkUrl = Url::to(['marks-accounting/update-mark']);
$actionDeleteMarkUrl = Url::to(['marks-accounting/delete-mark']);
$retakeFormUrl = Url::to(['marks-accounting/retake-form']);

$js .= <<<JS
    jQuery('body').on('change', 'td[data-id] select, td[data-id] input', function(){
        var cell = jQuery(this).parents('td[data-id]');
        var JournalMark = {
            id: cell.data('id'),
            student_id: cell.data('student'),
            record_id: cell.data('record'),
            evaluation_id: cell.find('select').val(),
            ticket: cell.find('input').val()
        };
        var action = '$actionCreateMarkUrl';
        
        if(JournalMark.id){
            action = '$actionDeleteMarkUrl'.addUrlParam('id', JournalMark.id);
            if(JournalMark.evaluation_id){
                action = '$actionUpdateMarkUrl'.addUrlParam('id', JournalMark.id);
            }
        }
        $.ajax({
            url: action,
            type: 'POST',
            data: {JournalMark: JournalMark},
            dataType: "json",
            success: function(res){
                if(res){
                    if (res.data && res.data.id) {
                        cell.data('id', res.data.id);
                    }else{
                        cell.data('id', null);
                    }
                    $.notify({
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
            },
        });
    });
JS;

$js .= <<<JS
    jQuery('body').on('calendar.change', function(){
        location.reload();
    });
    jQuery('body').on('change', '#journalrecord-type, #journalrecord-isretake', function(e){
        var typeId = jQuery('#journalrecord-type').val();
        var isRetake = jQuery('#journalrecord-isretake').is(':checked');
        var loadId = jQuery('#journalrecord-load_id').val();
        jQuery.ajax({
            url: '$retakeFormUrl',
            type: 'POST',
            data: {JournalRecord: {load_id: loadId, type: typeId, isRetake: isRetake ? 1 : 0}},
            success: function(data) {
              jQuery('#retakePartial').html(data);
            }
        });
        if (jQuery(e.target).attr('id') === 'journalrecord-isretake'){
            e.preventDefault(e);
            return false;
        }
    });
JS;

$this->registerJS($js);
?>

<div class="journal">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?php if (!$isTeacher): ?>
        <div class="form-group">
            <?= Select2::widget([
                'name' => 'work_plan_id',
                'data' => WorkPlan::getList(),
                'options' => [
                    'id' => 'work_plan_id',
                    'placeholder' => Yii::t('app', 'Choose work plan')
                ],
                'pluginOptions' => ['allowClear' => true],
            ]) ?>
        </div>

        <div class="form-group">
            <?= DepDrop::widget([
                'name' => 'group_id',
                'type' => DepDrop::TYPE_SELECT2,
                'options' => ['id' => 'group_id'],
                'pluginOptions' => [
                    'depends' => ['work_plan_id'],
                    'url' => Url::to(['marks-accounting/get-groups']),
                    'placeholder' => Yii::t('app', 'Choose group'),
                ]
            ]) ?>
        </div>
    <?php endif ?>

    <div class="form-group">
        <?= DepDrop::widget([
            'name' => 'load_id',
            'data' => $loads,
            'value' => $load->id ?? '',
            'type' => DepDrop::TYPE_SELECT2,
            'options' => [
                'id' => 'load_select',
                'placeholder' => '',
            ],
            'pluginOptions' => [
                'depends' => ['work_plan_id', 'group_id'],
                'url' => Url::to(['marks-accounting/get-loads']),
                'placeholder' => Yii::t('app', 'Choose subject'),
            ]
        ]) ?>
    </div>

    <?php Pjax::begin([
        'id' => 'marks-accounting-widget',
        'timeout' => 99999,
    ]); ?>



    <?php if ($load->id): ?>
        <p>
            <?= Html::button(Yii::t('app', 'Add column'), ['class' => 'btn btn-success', 'data-toggle' => 'modal', 'data-target' => '#recordCreateModal']) ?>
            <?= Html::a(Yii::t('app', 'Export'), Url::to(['export', 'loadId' => $load->id]), ['class' => 'btn btn-info']) ?>
        </p>

        <?= $this->render('_create_record', [
            'record' => $record
        ]); ?>

        <table class="table table-condensed table-bordered table-hover">
            <thead>
            <tr>
                <th style="width: 35px;"><?= Yii::t('app', 'N p/p'); ?></th>
                <th><?= Yii::t('app', 'Student'); ?></th>
                <?php foreach ($records as $record): ?>
                    <th>
                        <?php if ($record->isExportable()): ?>
                            <div class="export-btn-wrap">
                                <?= Html::a(FA::icon(FA::_FILE), ['export', 'recordId' => $record->id], [
                                    'data-pjax' => 0,
                                ]) ?>
                            </div>
                        <?php endif ?>
                        <?= $record->getLabel() ?>
                    </th>
                <?php endforeach ?>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($load->group->getStudentsArray() as $index => $student): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $student->getShortName(); ?></td>
                    <?php foreach ($records as $record): ?>
                        <td class="<?= JournalHtmlHelper::getRecordCssClass($record) ?>"
                            data-id="<?= $marks[$student->id][$record->id]->id ?>"
                            data-student="<?= $student->id ?>"
                            data-record="<?= $record->id ?>">
                            <div>
                                <?= Html::dropDownList('mark', $marks[$student->id][$record->id]->evaluation_id ?? '', JournalMark::getListOfEvaluations($load->evaluation_system_id), [
                                    'class' => 'form-control',
                                ]) ?>

                                <?php if ($record->typeObj && $record->typeObj->ticket): ?>
                                    <?= Html::input('number', 'ticket', $marks[$student->id][$record->id]->ticket ?? '', [
                                        'class' => 'form-control no-spinner',
                                        'placeholder' => Yii::t('app', 'Ticket'),
                                    ]) ?>
                                <?php endif; ?>
                            </div>
                        </td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php Pjax::end(); ?>
</div>

