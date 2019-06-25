<?php

use app\modules\journal\models\record\JournalRecord;
use app\modules\journal\models\record\JournalRecordType;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $record JournalRecord */

?>

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
                    'data' => JournalRecordType::getMap('title'),
                    'pluginOptions' => [
                        'placeholder' => Yii::t('app', 'Choose type'),
                    ],
                ]) ?>
                <div id="retakePartial">
                    <?= $this->render('_retake', ['record' => $record, 'form' => $form, 'retakeItems'=>[]]) ?>
                </div>

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