<?php

use app\components\ExportHelpers;
use app\modules\directories\models\speciality\Speciality;
use app\modules\employee\models\Teacher;
use app\modules\plans\models\StudyPlan;
use app\modules\plans\models\StudySubject;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use app\modules\students\models\StudentsHistory;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $exportParams app\modules\students\models\ExportParams
 * /* @var $model app\modules\students\models\Group
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//var_dump($exportParams);die;
?>
<div class="group-view">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Get list group Excel document'), ['document', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <!--        TODO: ajax-submit on select Plan-->
    <?php $exportParams->plan = StudyPlan::findOne(["speciality_qualification_id" => $model->specialityQualification]); ?>
    <?php if ($exportParams->plan_id != "") {
        $exportParams->plan = StudyPlan::findOne(['id' => $exportParams->plan_id]);
    } else {
        $exportParams->plan_id = $exportParams->plan->id;
    } ?>
    <?php $form = ActiveForm::begin([
        'id' => 'plan-form',
        'action' => Url::to(['group/view', 'id' => $model->id]),
    ]) ?>

    <div class="row">
        <div class="col col-sm-8 col-md-6">
            <?= $form->field($exportParams, 'plan_id')->widget(Select2::className(), [
                'data' => StudyPlan::getList(),
                'options' => [
                    'class' => 'text-center',
                    'placeholder' => Yii::t('app', 'Select study plan'),
                    'id' => 'plan_id',
                    'onchange' => 'this.form.submit()',
//                'onchange' => '$.post("'.Yii::$app->urlManager->createUrl(["students/group/view",'id' => $model->id]).'")'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label(false); ?>
        </div>
        <div class="col  col-sm-8 col-md-6">
            <?php if ($exportParams['marks_checker'] == NULL) {
                $exportParams['marks_checker'] = true;
            } ?>
            <?= $form->field($exportParams, 'marks_checker')->widget(SwitchInput::class, [
                'pluginOptions' => [
                    'onColor' => 'warning',
                    'offColor' => 'danger',
                    'onText' => Yii::t('app', 'With marks'),
                    'offText' => Yii::t('app', 'Without marks'),
                ],
                'options' => [
                    'onchange' => 'this.form.submit()'
                ]
            ])->label(false);
            ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
    <p>
        <a href="#" id="attestation" class='btn btn-default'><?= Yii::t('app', 'Attestation note') ?></a>
        <a href="#" id="credit" class='btn btn-default'><?= Yii::t('app', 'Scoring note') ?></a>
        <a href="#" id="semester" class='btn btn-default'><?= Yii::t('app', 'Semester note') ?></a>
        <a href="#" id="exam" class='btn btn-default'><?= Yii::t('app', 'Examination note') ?></a>
    </p>
    <?php
    $mainAttributes = [
        [
            'label' => Yii::t('app', 'Speciality'),
            'value' => $model->specialityQualification->speciality->title,
        ],
        [
            'attribute' => 'speciality_qualifications_id',
            'value' => $model->specialityQualification->title,
        ],
        [
            'attribute' => 'created_study_year_id',
            'value' => $model->studyYear->getTitle(),
        ],
        'number_group',
        [
            'attribute' => 'systemTitle',
        ],
        'title',
        [
            'attribute' => 'group_leader_id',
            'format' => 'raw',
            'value' => $model->getGroupLeaderLink(),
        ],
        [
            'attribute' => 'curator_id',
            'format' => 'raw',
            'value' => $model->getCuratorLink(),
        ]
    ];
    $financeAttributes = [];
    foreach (StudentsHistory::getPayments() as $key => $value) {
        $financeAttributes[] = [
            'label' => $value,
            'format' => 'raw',
            'value' => $model->getCountByPayment($key),
        ];
    }
    $attributes = \yii\helpers\ArrayHelper::merge($mainAttributes, $financeAttributes);
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'student_code',
            //'sseed_id',
            //'user_id',
            'last_name',
            'first_name',
            'middle_name',
            'paymentTypeLabel',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        $customurl = Yii::$app->getUrlManager()->createUrl(['students/default/view', 'id' => $model['id']]); //$model->id для AR
                        return \yii\helpers\Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $customurl,
                            ['title' => Yii::t('yii', 'View'), 'data-pjax' => '0']);
                    },
                ],
            ],
        ],
    ]);
    ?>

</div>

<div class="dialog-window" id="attestation-window" style="display: none">
    <?php $form = ActiveForm::begin(['action' => ['attestation']]); ?>
    <div class="dialog-card">
        <div class="dialog-header text-left"><h4><?= Yii::t('app', 'Attestation note') ?></h4></div>
        <div class="dialog-content">

            <?= $form->field($exportParams, 'semester')->textInput(['placeholder' => 'Семестр', 'class' => 'dialog-input form-control text-center', 'type' => 'number'])->label(false) ?>
            <?= $form->field($exportParams, 'dateFrom')->widget(DatePicker::class, [
                'options' => [
                    'placeHolder' => Yii::t('app', 'Choose start date'),
                    'class' => 'text-center',
                    'id' => 'att-start-date'
                ],
                'type' => DatePicker::TYPE_INPUT,
                'language' => Yii::$app->language,
                'pluginOptions' => [
                    'clearBtn' => true,
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy'
                ],
            ])->label(false);
            ?>

            <?= $form->field($exportParams, 'dateTo')->widget(DatePicker::class, [
                'options' => ['placeHolder' => Yii::t('app', 'Choose finish date'), 'class' => 'text-center'],
                'type' => DatePicker::TYPE_INPUT,
                'language' => Yii::$app->language,
                'pluginOptions' => [
                    'clearBtn' => true,
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy'
                ],
            ])->label(false);
            ?>
            <?= $form->field($exportParams, 'group_id')->textInput(['readonly' => true, 'class' => 'dialog-input form-control'])->hiddenInput(['value' => $model->id])->label(false) ?>
            <?= $form->field($exportParams, 'plan_id')->textInput(['readonly' => true, 'class' => 'dialog-input form-control'])->hiddenInput(['value' => $exportParams->plan->id])->label(false) ?>
            <?= $form->field($exportParams, 'marks_checker')->textInput(['readonly' => true, 'class' => 'dialog-input form-control'])->hiddenInput(['value' => $exportParams->marks_checker])->label(false) ?>

        </div>
        <?= Html::submitButton(Yii::t('app', 'Print'), ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="dialog-background"></div>
</div>

<div class="dialog-window" id="credit-window" style="display: none">
    <?php $form = ActiveForm::begin(['action' => ['credit']]); ?>
    <div class="dialog-card">
        <div class="dialog-header text-left"><h4><?= Yii::t('app', 'Scoring note') ?></h4></div>
        <div class="dialog-content">
            <?= $form->field($exportParams, 'semester')->widget(Select2::class, [
                'data' => ExportHelpers::getSemesterList(),
                'options' => [
                    'placeholder' => Yii::t('app', 'Input semester'),
                    'id' => 'cred-sem',
                    'class' => 'dialog-input form-control text-center',
                ]
            ])->label(false) ?>

            <?= $form->field($exportParams, 'subject_id')->widget(DepDrop::className(), [
//                'data' => ArrayHelper::map($exportParams->plan->studySubjects, 'subject_id', 'title'),
                'pluginOptions' => [
                    'depends' => ['plan_id','cred-sem'],
                    'placeholder' => Yii::t('app', 'Select subject'),
                    'url' => Url::to(['subject-list']),
                ],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                'options' => [
                    'id' => 'subject-id',
                    'placeholder' => 'Select ...'
                ]
            ])->label(false) ?>

            <?= $form->field($exportParams, 'plan_id')->textInput(['readonly' => true, 'class' => 'dialog-input form-control'])->hiddenInput(['value' => $exportParams->plan->id])->label(false) ?>
            <?= $form->field($exportParams, 'marks_checker')->textInput(['readonly' => true, 'class' => 'dialog-input form-control'])->hiddenInput(['value' => $exportParams->marks_checker])->label(false) ?>
            <?= $form->field($exportParams, 'teachers_id')->widget(Select2::classname(), [
                'data' => Teacher::getAll(),
                'options' => ['class' => 'text-center form-control', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label(Yii::t('app', 'Select teachers'));
            ?>
            <?= $form->field($exportParams, 'group_id')->textInput(['readonly' => true, 'class' => 'dialog-input'])->hiddenInput(['value' => $model->id])->label(false) ?>
        </div>
        <?= Html::submitButton(Yii::t('app', 'Print'), ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="dialog-background"></div>
</div>

<div class="dialog-window" id="semester-window" style="display: none">
    <?php $form = ActiveForm::begin(['action' => ['semester']]); ?>
    <div class="dialog-card">
        <div class="dialog-header text-left"><h4><?= Yii::t('app', 'Semester note') ?></h4></div>
        <div class="dialog-content">
            <?= $form->field($exportParams, 'semester')->textInput(['placeholder' => Yii::t('app', 'Input semester'), 'class' => 'dialog-input text-center form-control', 'type' => 'number'])->label(false) ?>
            <?= $form->field($exportParams, 'dateFrom')->widget(DatePicker::class, [
                'options' => [
                    'placeHolder' => Yii::t('app', 'Choose start date'),
                    'class' => 'text-center',
                    'id' => 'year-chooser'
                ],
                'type' => DatePicker::TYPE_INPUT,
                'language' => Yii::$app->language,
                'pluginOptions' => [
                    'clearBtn' => true,
                    'autoclose' => true,
                    'minViewMode' => 'years',
                    'format' => 'yyyy'
                ],
            ])->label(false);
            ?>
            <?= $form->field($exportParams, 'group_id')->textInput(['readonly' => true, 'class' => 'dialog-input'])->hiddenInput(['value' => $model->id])->label(false) ?>
            <?= $form->field($exportParams, 'plan_id')->textInput(['readonly' => true, 'class' => 'dialog-input form-control'])->hiddenInput(['value' => $exportParams->plan->id])->label(false) ?>
            <?= $form->field($exportParams, 'marks_checker')->textInput(['readonly' => true, 'class' => 'dialog-input form-control'])->hiddenInput(['value' => $exportParams->marks_checker])->label(false) ?>
        </div>
        <?= Html::submitButton(Yii::t('app', 'Print'), ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="dialog-background"></div>
</div>
<div class="dialog-window" id="exam-window" style="display: none">
    <?php $form = ActiveForm::begin(['action' => ['exam']]); ?>
    <div class="dialog-card">
        <div class="dialog-header text-left"><h4><?= Yii::t('app', 'Examination note') ?></h4></div>
        <div class="dialog-content">
            <?= $form->field($exportParams, 'semester')->widget(Select2::class, [
                'data' => ExportHelpers::getSemesterList(),
                'options' => [
                    'placeholder' => Yii::t('app', 'Input semester'),
                    'id' => 'ex-sem',
                    'class' => 'dialog-input form-control text-center',
                ]
            ])->label(false) ?>

            <?= $form->field($exportParams, 'subject_id')->widget(DepDrop::className(), [
                'pluginOptions' => [
                    'depends' => ['plan_id','ex-sem'],
                    'placeholder' => Yii::t('app', 'Select subject'),
                    'url' => Url::to(['subject-list']),
                ],
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                'options' => [
                    'id' => 'exam-subject-id',
                    'placeholder' => 'Select ...'
                ]
            ])->label(false) ?>
            <?= $form->field($exportParams, 'plan_id')->textInput(['readonly' => true,'class' => 'dialog-input form-control'])->hiddenInput(['value' => $exportParams->plan->id])->label(false) ?>
            <?= $form->field($exportParams, 'marks_checker')->textInput(['readonly' => true, 'class' => 'dialog-input form-control'])->hiddenInput(['value' => $exportParams->marks_checker])->label(false) ?>
            <?= $form->field($exportParams, 'teachers_id')->widget(Select2::classname(), [
                'data' => \app\modules\employee\models\Teacher::getAll(),
                'options' => ['class' => 'text-center form-control', 'multiple' => true, 'id' => 'exam-teacher-select'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label(Yii::t('app', 'Select teachers'));
            ?>
            <?= $form->field($exportParams, 'group_id')->textInput(['readonly' => true, 'class' => 'dialog-input'])->hiddenInput(['value' => $model->id])->label(false) ?>
        </div>
        <?= Html::submitButton(Yii::t('app', 'Print'), ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="dialog-background"></div>
</div>
