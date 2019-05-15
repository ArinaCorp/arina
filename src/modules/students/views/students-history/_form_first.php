<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\students\models\StudentsHistory;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\StudentsHistoryBefore */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="students-history-before-form">

    <?php $form = ActiveForm::begin([
    ]); ?>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'category_id')->widget(Select2::class, [
                'name' => 'category',
                'data' => StudentsHistory::getStudentCategoryList(),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select category'),
                ],
            ]);
            ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'group_search_id')->widget(DepDrop::class, [
                'name' => 'group',
                'data' => [],
                'options' => ['placeholder' => 'Select group'],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                'pluginOptions' => [
                    'depends' => ['studentshistorybefore-category_id'],
                    'url' => Url::to(['get-groups-list']),
                    'loadingText' => Yii::t('app', 'Loading ...'),
                ]
            ]);
            ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'student_id')->widget(DepDrop::class,
                [
                    'data' => [],
                    'options' => ['placeholder' => Yii::t('app','Select ...')],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'pluginOptions' => [
                        'depends' => ['studentshistorybefore-category_id', 'studentshistorybefore-group_search_id'],
                        'url' => Url::to(['get-students-list']),
                        'loadingText' => Yii::t('app', 'Loading ...'),
                    ],
                ])
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'date')->widget(DatePicker::class, [
                'language' => Yii::$app->language,
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                ],
            ]); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'parent_id')->widget(DepDrop::class,
                [
                    'data' => [],
                    'options' => ['placeholder' => Yii::t('app','Select ...')],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'pluginOptions' => [
                        'depends' => ['studentshistorybefore-student_id'],
                        'url' => Url::to(['get-student-parents']),
                        'loadingText' => Yii::t('app', 'Loading ...'),
                    ],
                ]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'action_type')->widget(DepDrop::class,
                [
                    'data' => [],
                    'options' => ['placeholder' => Yii::t('app','Select ...')],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'pluginOptions' => [
                        'depends' => ['studentshistorybefore-parent_id'],
                        'url' => Url::to(['get-permitted-actions']),
                        'loadingText' => Yii::t('app', 'Loading ...'),
                    ],
                ])
            ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Next step'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
