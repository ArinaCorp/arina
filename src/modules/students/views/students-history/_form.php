<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\students\models\Student;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\students\models\StudentsHistory;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\modules\directories\models\StudyYear;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\StudentsHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="students-history-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'category_id')->widget(Select2::className(), [
                'name' => 'category',
                'data' => StudentsHistory::getStudentCategoryList(),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select category'),
                ],
            ]);
            ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'group_search_id')->widget(DepDrop::className(), [
                'name' => 'group',
                'data' => [],
                'options' => ['placeholder' => 'Select group'],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                'pluginOptions' => [
                    'depends' => ['studentshistory-category_id'],
                    'url' => Url::to(['get-groups-list']),
                    'loadingText' => Yii::t('app', 'Loading ...'),
                ]
            ]);
            ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'student_id')->widget(DepDrop::className(),
                [
                    'data' => [],
                    'options' => ['placeholder' => 'Select ...'],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'pluginOptions' => [
                        'depends' => ['studentshistory-category_id', 'studentshistory-group_search_id'],
                        'url' => Url::to(['get-students-list']),
                        'loadingText' => Yii::t('app', 'Loading ...'),
                    ],
                ])
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'date')->widget(dosamigos\datepicker\DatePicker::className(), [
                'language' => 'uk',
                'clientOptions' => [
                    'autoclose' => true,
                ]
            ]); ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'parent_id')->widget(DepDrop::className(),
                [
                    'data' => [],
                    'options' => ['placeholder' => 'Select ...'],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'pluginOptions' => [
                        'depends' => ['studentshistory-student_id'],
                        'url' => Url::to(['get-student-parents']),
                        'loadingText' => Yii::t('app', 'Loading ...'),
                    ],
                ]) ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'action_type')->widget(DepDrop::className(),
                [
                    'data' => [],
                    'options' => ['placeholder' => 'Select ...'],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'pluginOptions' => [
                        'depends' => ['studentshistory-parent_id'],
                        'url' => Url::to(['get-permitted-actions']),
                        'loadingText' => Yii::t('app', 'Loading ...'),
                    ],
                ])
            ?>
        </div>
    </div>

    <?= $form->field($model, 'speciality_qualification_id')->dropDownList(SpecialityQualification::getTreeList()) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
