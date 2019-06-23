<?php

use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\speciality_qualification\SpecialityQualification;
use app\modules\directories\models\subject_block\SubjectBlock;
use app\modules\plans\models\WorkPlan;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\modules\directories\models\subject\Subject;

/* @var $this View
 * @var $model SubjectBlock
 * @var $form ActiveForm
 */

?>

<div class="subject-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-sm-6">

            <?= $form->field($model, 'work_plan_id')->widget(Select2::class, [
                'data' => WorkPlan::getList(),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select plan'),
                ],
            ]); ?>

            <!-- TODO: Add localization -->
            <?= $form->field($model, 'course')->dropDownList([1 => 'Перший', 2 => 'Другий', 3 => 'Третій', 4 => 'Четвертий']); ?>

            <?= $form->field($model, 'semester')->dropDownList([1 => 'Перший', 2 => 'Другий']); ?>

            <?= $form->field($model, 'selectedSubjects')->widget(DepDrop::class, [
                'type' => DepDrop::TYPE_SELECT2,
                'select2Options' => [
                    'pluginOptions' => [
                        'multiple' => true,
                    ],
                ],
                'data' => ArrayHelper::map($model->workSubjects, 'id', 'title'),
                'pluginOptions' => [
                    'depends' => ['subjectblock-work_plan_id', 'subjectblock-course', 'subjectblock-semester'],
                    'initialize' => true,
                    'placeholder' => Yii::t('app', 'Select ...'),
                    'url' => Url::to(['/directories/subject-block/get-optional-subjects']),
                ],
            ]); ?>

        </div>

    </div>

    <div class="form-group">

        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
