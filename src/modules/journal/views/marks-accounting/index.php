<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 30.04.2019
 * Time: 13:31
 */

use app\modules\journal\models\record\JournalMark;
use app\modules\journal\models\record\JournalRecord;
use app\modules\load\models\Load;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/**
 * @var array $loads
 * @var Load $load
 * @var JournalRecord $record
 * @var JournalMark[] $marks
 */

$this->title = Yii::t('app', 'Journal Marks');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$actionUrl = Url::to(['marks-accounting/index']);

$this->registerJS(<<<JS
    $('#load_select').on('change', function(){
        $.pjax.reload({
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
JS
);
?>

<div>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <div class="form-group">
        <?= Select2::widget([
            'options' => [
                'id' => 'load_select'
            ],
            'name' => 'load_id',
            'value' => $load->id ?? '',
            'data' => $loads,
            'pluginOptions' => [
                'placeholder' => Yii::t('journal', 'Choose subject')
            ],
        ]) ?>
    </div>


    <?php Pjax::begin([
        'id' => 'marks-accounting-widget',
        'timeout' => 99999,
    ]); ?>


    <?php if ($load->id): ?>
        <p>
            <?= Html::button(Yii::t('app', 'Add column'), ['class' => 'btn btn-success', 'data-toggle' => 'modal', 'data-target' => '#recordCreateModal']) ?>
            <?= Html::submitButton(FA::icon('floppy-o'), [
                'title' => Yii::t('app', 'Save and stay here'),
                'data-action' => 'save',
                'class' => 'btn btn-info save-btn',
            ]) ?>
        </p>
    <?php endif ?>

    <div class="modal fade" id="recordCreateModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><?= Yii::t('app', 'Add column') ?></h4>
                </div>
                <?php $form = ActiveForm::begin([
                    'options' => ['data-pjax' => ''],
                    'id' => 'recordCreateFrom',
                ]); ?>
                <div class="modal-body">

                    <?= $form->field($record, 'teacher_id')->hiddenInput()->label(false) ?>
                    <?= $form->field($record, 'load_id')->hiddenInput()->label(false) ?>

                    <?= $form->field($record, 'type')->widget(Select2::class, [
                        'data' => JournalRecord::getTypes(),
                        'pluginOptions' => [
                            'placeholder' => Yii::t('journal', 'Choose type')
                        ]
                    ]) ?>

                    <?= $form->field($record, 'date')->widget(DatePicker::class, [
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'autoclose' => true
                        ]
                    ]) ?>

                </div>
                <div class="modal-footer">
                    <?= Html::button(Yii::t('app', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
                    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'id' => 'add_column']); ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>


    <?php if ($load->id): ?>
        <table class="table table-striped table-condensed table-bordered table-hover">
            <thead>
            <tr>
                <th><?= Yii::t('app', 'Student'); ?></th>
                <?php foreach ($load->journalRecords as $record): ?>
                    <th style="width: 40px;">
                        <?= $record->date . ' ' . $record->getType() ?>
                    </th>
                <?php endforeach ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($load->group->getStudentsArray() as $student): ?>
                <tr>
                    <td><?= $student->getShortName(); ?></td>
                    <?php foreach ($load->journalRecords as $record): ?>
                        <td> <?= Html::input('text', 'mark', $marks[$student->id][$record->id] ?? '') ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php Pjax::end(); ?>
</div>

