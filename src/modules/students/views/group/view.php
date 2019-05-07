<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use app\modules\students\models\StudentsHistory;

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
    <p>
        <a href="#" id="attestation" class='btn btn-default'><?= Yii::t('app', 'Attestation note') ?></a>
        <a href="#" id="zalik" class='btn btn-default'><?= Yii::t('app', 'Scoring note') ?></a>
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
            'value' => $model->studyYear->getFullName(),
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
            <?= $form->field($exportParams, 'semester')->textInput(['placeholder' => 'Семестр', 'class' => 'dialog-input form-control', 'type' => 'number'])->label(false) ?>
            <?= $form->field($exportParams, 'date')->textInput(['placeholder' => 'Дата початку дії д.м.р', 'class' => 'dialog-input form-control'])->label(false) ?>
            <?= $form->field($exportParams, 'group_id')->textInput(['readonly' => true, 'class' => 'dialog-input form-control'])->hiddenInput(['value' => $model->id])->label(false) ?>
        </div>
        <?= Html::submitButton(Yii::t('app', 'Print'), ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="dialog-background"></div>
</div>

<div class="dialog-window" id="zalik-window" style="display: none">
    <?php $form = ActiveForm::begin(['action' => ['zalik']]); ?>
    <div class="dialog-card">
        <div class="dialog-header text-left"><h4><?= Yii::t('app', 'Scoring note') ?></h4></div>
        <div class="dialog-content">
            <?= $form->field($exportParams, 'subject_id')->widget(Select2::classname(), [
                'data' => \app\modules\directories\models\subject\Subject::getList(),
                'options' => ['placeholder' => 'Предмет'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label(false); ?>
            <?= $form->field($exportParams, 'semester')->textInput(['placeholder' => 'Cеместр', 'class' => 'dialog-input text-center form-control','type'=>'number'])->label(false) ?>
            <?= $form->field($exportParams, 'course')->textInput(['placeholder' => 'Курс', 'class' => 'dialog-input text-center form-control','type'=>'number'])->label(false) ?>
            <?= $form->field($exportParams, 'teachers_id')->widget(Select2::classname(), [
                'data' => \app\modules\employee\models\Teacher::getAll(),
                'options' => ['class' => 'dialog-input','placeholder' => 'Викладачі','multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label(false);
            ?>
            <?= $form->field($exportParams, 'group_id')->textInput(['readonly' => true, 'class' => 'dialog-input'])->hiddenInput(['value' => $model->id])->label(false) ?>
        </div>
        <?= Html::submitButton(Yii::t('app', 'Print'), ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="dialog-background"></div>
</div>

<div class="dialog-window" id="semester-window" style="display: none">
    <?php $form = ActiveForm::begin(['action' => ['print']]); ?>
    <div class="dialog-card">
        <div class="dialog-header text-left"><h4><?= Yii::t('app', 'Semester note') ?></h4></div>
        <div class="dialog-content">
            <!--            --><? //= $form->field($exportParams, 'semester')->textInput(['placeholder'=>'Семестр','class'=>'dialog-input','type'=>'number'])->label(false) ?>
            <!--            --><? //= $form->field($exportParams, 'date')->textInput(['placeholder'=>'Дата початку дії д.м.р','class'=>'dialog-input'])->label(false) ?>
            <!--            --><? //= $form->field($exportParams, 'group_id')->textInput(['readonly' => true,'class'=>'dialog-input'])->hiddenInput(['value' => $model->id])->label(false) ?>
        </div>
        <?= Html::submitButton(Yii::t('app', 'Print'), ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="dialog-background"></div>
</div>

<div class="dialog-window" id="exam-window" style="display: none">
    <?php $form = ActiveForm::begin(['action' => ['print']]); ?>
    <div class="dialog-card">
        <div class="dialog-header text-left"><h4><?= Yii::t('app', 'Examination note') ?></h4></div>
        <div class="dialog-content">
            <!--            --><? //= $form->field($exportParams, 'semester')->textInput(['placeholder'=>'Семестр','class'=>'dialog-input','type'=>'number'])->label(false) ?>
            <!--            --><? //= $form->field($exportParams, 'date')->textInput(['placeholder'=>'Дата початку дії д.м.р','class'=>'dialog-input'])->label(false) ?>
            <!--            --><? //= $form->field($exportParams, 'group_id')->textInput(['readonly' => true,'class'=>'dialog-input'])->hiddenInput(['value' => $model->id])->label(false) ?>
        </div>
        <?= Html::submitButton(Yii::t('app', 'Print'), ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="dialog-background"></div>
</div>

<style>
    .dialog-window,.dialog-background{
        position: fixed;
        flex-direction: column;
        justify-content: center;
        height: 100vh;
        width: 100vw;
        top: 0;
        left: 0;
        z-index: 998;
    }

    .dialog-background {
        background-color: rgba(0, 0, 0, .1);
    }

    .dialog-card {
        position: relative;
        margin: auto;
        width: 330px;
        padding: 10px 20px 10px 20px;
        background: white;
        text-align: center;
        box-shadow: 0 3px 6px rgba(0, 0, 0, .4);
        z-index: 999;
    }

    .dialog-header {
        color: rgba(0, 0, 0, .6);
        border-bottom: solid 1.5px rgba(0, 0, 0, .2);
        user-select: none;
    }

    .dialog-content {
        padding-top: 30px;
    }

    /*.dialog-input {*/
    /*    border: none;*/
    /*    border-bottom: solid 1.5px rgba(0, 0, 0, .2);*/
    /*    text-align: center;*/
    /*    !*margin-bottom: 20px;*!*/
    /*    outline: none;*/
    /*}*/
</style>
