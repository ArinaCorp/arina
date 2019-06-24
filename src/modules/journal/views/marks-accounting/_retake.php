<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2019 NRE
 * @var $record \app\modules\journal\models\record\JournalRecord
 * @var $form \yii\widgets\ActiveForm
 * @var $retakeItems array
 */
 ?>

<?php if ($record->typeObj && $record->typeObj->has_retake): ?>
    <?= $form->field($record, 'isRetake')->checkbox() ?>
    <?php if ($record->isRetake): ?>
        <?= $form->field($record, 'retake_for_id')->dropDownList($retakeItems) ?>
    <?php endif ?>
<?php else: ?>
    <?= $form->field($record, 'isRetake')->hiddenInput()->label(false) ?>
<?php endif ?>
