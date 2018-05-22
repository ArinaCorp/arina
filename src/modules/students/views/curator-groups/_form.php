<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\students\models\Group;
use app\modules\employee\models\Employee;
use app\modules\students\models\CuratorGroup;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\CuratorGroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="curator-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group_id')->widget(Select2::class, [
        'data' => Group::getActiveGroupsList(),
        'options' => [
            'placeholder' => Yii::t('app', 'Select group'),
        ],
        'pluginOptions' =>
            [
                'allowClear' => true
            ]
    ]); ?>

    <?= $form->field($model, 'type')->widget(DepDrop::class, [
        'name' => 'teacher',
        'data' => [],
        'options' => ['placeholder' => Yii::t('app', 'Select group')],
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
        'pluginOptions' => [
            'depends' => ['curatorgroup-group_id'],
            'url' => Url::to(['get-types-list']),
            'loadingText' => Yii::t('app', 'Loading ...'),
        ]
    ]) ?>

    <?= $form->field($model, 'teacher_id')->widget(DepDrop::class, ['name' => 'teacher',
        'data' => [],
        'options' => ['placeholder' => Yii::t('app', 'Select group')],
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
        'pluginOptions' => ['depends' => ['curatorgroup-group_id', 'curatorgroup-type'],
            'url' => Url::to(['get-teachers-list']),
            'loadingText' => Yii::t('app', 'Loading ...'),
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
