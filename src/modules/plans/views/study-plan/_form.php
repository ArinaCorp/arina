<?php

use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\plans\models\StudyPlan;
use app\modules\plans\widgets\Graph;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use yii\widgets\Pjax;

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
            <?= $form->field($model, 'speciality_qualification_id')->widget(Select2::class, [
                'data' => SpecialityQualification::getTreeList(),
                'id' => 'speciality_qualification_id',
                'options' =>
                    [
                        'placeholder' => $model->getAttributeLabel('speciality_qualification_id')
                    ]
            ]); ?>
        </div>
    </div>
    <?php if ($model->isNewRecord): ?>
        <div class="row">
            <div class="col-sm-6">
                <?= Select2::widget(
                    [
                        'data' => StudyPlan::getList(),
                        'id' => 'origin',
                        'name' => 'origin',
                        'options' => [
                            'placeholder' => Yii::t('plans', 'Select copy plan')
                        ]
                    ]
                ); ?>
            </div>
            <br/><br/>
        </div>
    <?php endif; ?>

    <?= Graph::widget(['model' => $model, 'field' => '', 'graph' => $model->graph]); ?>

    <?= $this->render('/_form_buttons', ['model' => $model, 'plan' => True]) ?>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>
</div>