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

/**
 * This view is used for student role. All data is current to the moment of plan creation.
 * @var $this View
 * @var $model StudentPlan
 * @var $form ActiveForm
 *
 * @var $user User
 */

$user = Yii::$app->user->identity;
?>

<div class="subject-form">

    <?php $form = ActiveForm::begin([
        'action' => [$model->isNewRecord ? '/plans/student-plan/create' : '/plans/student-plan/update']
    ]); ?>

    <div class="row">

        <div class="col-sm-6">

            <?= $form->field($model, 'subject_block_id')->widget(Select2::class, [
                'data' => SubjectBlock::getMap('title', 'id', [
                    'work_plan_id' => $model->work_plan_id,
                    'course' => $user->student->course,
                    'semester' => $user->student->currentSemester
                ], false),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select ...'),
                ],
            ]); ?>


            <div id="subject-block-preview" class="col-lg-12">

            </div>

        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
// If this is update action, do an init.
if (!$model->isNewRecord) {
    $js .= <<<JS
jQuery.ajax({
    url: '$jUrlSubjectBlockView',
    type: 'get',
    data: {id: jQuery('#studentplan-subject_block_id').val()},
    success: function (data) {
        jQuery('#subject-block-preview').html(data);
    }
});
JS;
}

$this->registerJs($js);
?>



