<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\journal\models\record\JournalRecordType;
use kartik\select2\Select2;
use app\modules\journal\models\presence\NotPresenceType;
use kartik\switchinput\SwitchInput;
use app\modules\journal\models\evaluation\EvaluationSystem;
use kartik\depdrop\DepDrop;
use app\modules\journal\models\evaluation\Evaluation;

/* @var $this yii\web\View */
/* @var $model app\modules\journal\models\record\JournalMark */
/* @var $form yii\widgets\ActiveForm */
/* @var $type JournalRecordType */
?>

<div class="journal-mark-form">

    <?php
    $form = ActiveForm::begin(); ?>
    <?php if ($type->present) : ?>
        <?= $form->field($model, 'presence')->widget(SwitchInput::class, [
            'options' => [
                'id' => 'not-present-check',
            ],
            'pluginOptions' =>
                [
                    'onText' => Yii::t('app', 'Yes'),
                    'offText' => Yii::t('app', 'No'),
                ],
            'pluginEvents' => [
                "switchChange.bootstrapSwitch" => "function() 
                { 
                
                 }",
            ]
        ]); ?>
        <div id="not-presence-container" style="">
            <?= $form->field($model, 'not_presence_reason_id')->widget(Select2::class, [
                'data' => NotPresenceType::getAllList(),
                'options' => [
                    'class' => 'hidden',
                    'placeholder' => Yii::t('app', 'Select not presence type')
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ]) ?>
        </div>
    <?php endif; ?>
    <?= $form->field($model, 'evaluation_system_id')->widget(Select2::class, [
        'data' => EvaluationSystem::getMap('title'),
        'options' => [
            'placeholder' => Yii::t('app', "Set evaluation system"),
        ],
        'pluginOptions' => [
            'allowClear' => true,
        ]
    ]) ?>
    <?php
    $evaluation = [];
    if (isset($model->evaluation_system_id)) {
        $evaluation = Evaluation::getListBySystem($model->evaluation_system_id);
    }
    ?>
    <?= $form->field($model, 'evaluation_id')->widget(DepDrop::class, [
        'data' => $evaluation,
        'options' => [
            'placeholder' => Yii::t('app', 'Select mark')
        ],
        'pluginOptions' => [
            'depends' => ['journalmark-evaluation_system_id'],
            'url' => ['get-evaluation-list'],
            'allowClear' => true,
        ]
    ]) ?>

    <?php if ($type->ticket) : ?>
        <?= $form->field($model, 'ticket')->textInput() ?>
    <?php endif; ?>
    <?= $form->field($model, 'retake_evaluation_id')->widget(DepDrop::class, ['data' => $evaluation,
        'options' => [
            'placeholder' => Yii::t('app', 'Select mark')
        ],
        'pluginOptions' => [
            'depends' => ['journalmark-evaluation_system_id'],
            'url' => ['get-evaluation-list'],
            'allowClear' => true,
        ]

    ]) ?>
    <?php if ($type->ticket) : ?>
        <?= $form->field($model, 'retake_ticket')->textInput() ?>
    <?php endif; ?>
    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>


    <?php ActiveForm::end(); ?>

</div>
