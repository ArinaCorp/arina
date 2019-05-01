<?php

use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\students\models\Group;
use app\modules\students\models\Student;
use app\modules\students\models\StudentsHistory;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\StudentsHistoryBefore */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="students-history-before-form">

    <?php $form = ActiveForm::begin([
    ]); ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'student_id')->widget(Select2::class, [
                'data' => [
                    $model->student_id => Student::findOne(['id' => $model->student_id])->fullNameAndCode,
                ],
                'disabled' => true,
                'readonly' => true,
            ])
            ?>
        </div>
        <div class="col-sm-6">
            <?php if ($model->parent_id): ?>
                <?= $form->field($model, 'parent_id')->widget(Select2::class, [
                    'data' => [
                        $model->parent_id => StudentsHistory::getStudentParentsList($model->student_id)[$model->parent_id],
                    ],
                    'disabled' => true,
                    'readonly' => true,
                ]);
                ?>
            <?php else: ?>
                <?= $form->field($model, 'parent_id')->hiddenInput()->label(false) ?>
            <?php endif ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'date')->widget(DatePicker::class, [
                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                'readonly' => true,
                'disabled' => true,
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                ],
            ]); ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'action_type')->widget(Select2::class,
                [
                    'data' =>
                        [
                            $model->action_type => StudentsHistory::getActionsTypes()[$model->action_type],
                        ],
                    'disabled' => true,
                    'readonly' => true,
                ]);
            ?>
        </div>
    </div>
    <?php
    switch ($model->action_type) {
    case StudentsHistory::$TYPE_INCLUDE :
    case StudentsHistory::$TYPE_RENEWAL :
    case StudentsHistory::$TYPE_TRANSFER_SPECIALITY_QA : {
    ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'speciality_qualification_id')->widget(Select2::class,
                [
                    'options' => ['placeholder' => Yii::t('app', 'Select')],
                    'data' => SpecialityQualification::getTreeList(),
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ])
            ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'group_id')->widget(DepDrop::class, [
                'name' => 'group',
                'data' => [],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                'pluginOptions' => [
                    'depends' => ['studentshistoryall-speciality_qualification_id'],
                    'url' => Url::to(['get-groups-list-from-speciality-qualification']),
                    'loadingText' => Yii::t('app', 'Loading ...'),
                    'placeholder' => Yii::t('app', 'Select'),
                ]
            ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'payment_type')->widget(Select2::class, [
                'options' => ['placeholder' => Yii::t('app', 'Select')],
                'data' => StudentsHistory::getPayments(),
                'pluginOptions' => [
                    'allowClear' => true,
                ]
            ]);
            ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'course')->widget(DepDrop::class, [
                'name' => 'course',
                'data' => [],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options' => [
                    'pluginOptions' => ['allowClear' => true
                    ]],
                'pluginOptions' => [
                    'placeholder' => Yii::t('app', 'Select'),
                    'depends' => ['studentshistoryall-group_id'],
                    'url' => Url::to(['get-courses-group']),
                    'loadingText' => Yii::t('app', 'Loading ...'),
                ]
            ]);
            ?>
        </div>
        <?
        break;
        }
        case StudentsHistory::$TYPE_TRANSFER_COURSE :
            {
                ?>
                <?php if ($model->parent_id): ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($model, 'course')->widget(Select2::class, [
                                'options' => ['placeholder' => Yii::t('app', 'Select')],
                                'data' => StudentsHistory::getCurrentGroupById($model->parent_id)->getCoursesList(),
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                <?php endif ?>
                <?php
                break;
            }
        case StudentsHistory::$TYPE_TRANSFER_GROUP :
            {
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'group_id')->widget(Select2::class, [
                            'options' => ['placeholder' => Yii::t('app', 'Select')],
                            'data' => Group::findOne(['id' => $model->data['current']['group_id']]),
                            'pluginOptions' => [
                                'allowClear' => true,
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <?php
                break;
            }
        case StudentsHistory::$TYPE_TRANSFER_FOUNDING :
            {
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'payment_type')->widget(Select2::class, [
                            'options' => ['placeholder' => Yii::t('app', 'Select')],
                            'data' => StudentsHistory::getPayments(),
                            'pluginOptions' => [
                                'allowClear' => true,
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <?php
                break;
            }
        }
        ?>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= $form->field($model, 'command')->textInput(); ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
