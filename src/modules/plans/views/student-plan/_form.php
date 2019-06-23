<?php

use app\components\DepDropHelper;
use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\subject_block\SubjectBlock;
use app\modules\plans\models\StudentPlan;
use app\modules\plans\models\WorkPlan;
use app\modules\students\models\Student;
use app\modules\user\helpers\UserHelper;
use app\modules\user\models\User;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\modules\directories\models\subject\Subject;
use yii\widgets\DetailView;

/* @var $this View
 * @var $model StudentPlan
 * @var $form ActiveForm
 *
 * @var $user User
 */

$user = Yii::$app->user->identity;
?>

<div class="subject-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-sm-6">

                <?= $form->field($model, 'student_id')->widget(Select2::class, [
                    'data' => Student::getList(),
                    'options' => [
                        'placeholder' => Yii::t('app', 'Select ...'),
                    ],
                ]) ?>

                <?= $form->field($model, 'work_plan_id')->widget(DepDrop::class, [
                    'type' => DepDrop::TYPE_SELECT2,
                    'data' => [$model->work_plan_id => 'default'],
                    'pluginOptions' => [
                        'depends' => ['studentplan-student_id'],
                        'placeholder' => Yii::t('app', 'Select ...'),
                        'url' => Url::to(['/plans/student-plan/get-student-work-plans']),
                    ],
                ]); ?>

                <?= $form->field($model, 'semester')->dropDownList([1 => 'Перший', 2 => 'Другий']); ?>

            <?= $form->field($model, 'subject_block_id')->widget(DepDrop::class, [
                'type' => DepDrop::TYPE_SELECT2,
                'data' => [$model->subject_block_id => 'default'],
                'pluginOptions' => [
                    'depends' => ['studentplan-student_id', 'studentplan-work_plan_id', 'studentplan-semester'],
                    'placeholder' => Yii::t('app', 'Select ...'),
                    'url' => Url::to(['/plans/student-plan/get-student-subject-blocks']),
                ],
            ]); ?>


            <div id="subject-block-preview" class="col-lg-12">

            </div>

        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$jUrlSubjectBlockView = Url::to(['/directories/subject-block/subject-preview']);
$js = <<<JS
jQuery('#studentplan-subject_block_id').on('change', function () {
    jQuery.ajax({
        url: '$jUrlSubjectBlockView',
        type: 'get',
        data: {id: jQuery('#studentplan-subject_block_id').val()},
        success: function (data) {
            jQuery('#subject-block-preview').html(data);
        }
    });
});
JS;
$this->registerJs($js);
?>



