<?php

use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\helpers\Url;

use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\plans\models\StudyPlan;
use app\modules\plans\widgets\Graph;
use app\modules\directories\models\StudyYear;
use app\modules\plans\models\WorkPlan;

/**
 * @var $this View
 * @var $model StudyPlan
 * @var ActiveForm $form
 */
?>

<div class="study-plan-form">
    <?php Pjax::begin(); ?>

    <?php $form = ActiveForm::begin(
        [
            'id' => 'dynamic-form',
            'options' => [
                'enctype' => 'multipart/form-data',
            ],

        ]
    ); ?>

    <p class="note"><?php echo Yii::t('app', 'Fields with <span class="required">*</span> are required.'); ?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'speciality_qualification_id')->widget(Select2::className(), [
                'data' => SpecialityQualification::getList(),
                'id' => 'speciality_qualification_id',
                'options' =>
                    [
                        'placeholder' => $model->getAttributeLabel('speciality_qualification_id')
                    ]
            ]);?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'study_year_id')->widget(Select2::className(), [
                'data' => StudyYear::getList(),
                'id' => 'study_year_id',
                'options' =>
                    [
                        'placeholder' => $model->getAttributeLabel('study_year_id')
                    ]
            ]);?>
        </div>
    </div>

    <?php if ($model->isNewRecord): ?>
        <label class="control-label"><?= Yii::t('plans', 'Base study plan'); ?></label>
        <div class="row">
            <div class="col-sm-6">
                <?= Select2::widget(
                    [
                        'data' => StudyPlan::getList(),
                        'id' => 'study_origin',
                        'name' => 'study_origin',
                        'options' =>
                            [
                                'placeholder' => Yii::t('plans', 'Select copy of study plan')
                            ]
                    ]
                );?>
            </div>
        </div>
        <br/>

        <label class="control-label"><?= Yii::t('plans', 'Base work plan'); ?></label>
        <div class="row">
            <div class="col-sm-6">
                <?= Select2::widget(
                    [
                        'data' => WorkPlan::getList(),
                        'id' => 'work_origin',
                        'name' => 'work_origin',
                        'options' =>
                            [
                                'placeholder' => Yii::t('plans', 'Select copy of work plan')
                            ]
                    ]
                );?>
            </div>
        </div>
        <br/>
    <?php endif; ?>

    <?= $this->render('/_form_buttons', ['model' => $model, 'plan' => False]) ?>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>
</div>
