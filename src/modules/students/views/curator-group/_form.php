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

    <?= $form->field($model, 'group_id')->widget(Select2::className(), [
        'data' => Group::getActiveGroupsList(),
        'options' => [
            'placeholder' => Yii::t('app', 'Select group'),
        ],
        'pluginOptions' =>
            [
                'allowClear' => true
            ]

    ]) ?>
    <?= $form->field($model, 'type')->widget(Select2::className(),
        [
            'data' => CuratorGroup::getTypesList(),
            'pluginOptions' =>
                [
                    'allowClear' => true
                ],
            'options' => [
                'placeholder' => Yii::t('app', 'Select action type'),
            ],
        ]) ?>

    <?= $form->field($model, 'teacher_id')->widget(DepDrop::className(), [
        'name' => 'group',
        'data' => [],
        'options' => ['placeholder' => Yii::t('app', 'Select group')],
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
        'pluginOptions' => [
            'depends' => ['studentshistorybefore-category_id', 'studentshistorybefore-group_search_id'],
            'url' => Url::to(['get-teacher-list']),
            'loadingText' => Yii::t('app', 'Loading ...'),
        ]
    ]); ?>



    <?= $form->field($model, 'date')->widget(DatePicker::className(), [
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        //'readonly' => true,
        //'disabled' => true,
        'pluginOptions' => [
            'format' => 'dd.mm.yyyy',
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
