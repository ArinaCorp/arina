<?php

use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\subject_block\SubjectBlock;
use app\modules\plans\models\StudentPlan;
use app\modules\plans\models\WorkPlan;
use app\modules\students\models\Student;
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
 */

?>

<div class="subject-form">

    <?php $form = ActiveForm::begin(['id' => 'student-plan-form']); ?>

    <div class="row">

        <div class="col-sm-6">

            <?= $form->field($model, 'student_id')->widget(Select2::class, [
                'data' => Student::getList(),
                'options' => [
                    'id' => 'student-id',
                    'placeholder' => Yii::t('app', 'Select speciality'),
                    'onchange' => 'loadSubBlockSelect(event)'
                ],
            ]) ?>
            <!--  Hidden checkbox used with javaScript  -->
            <div class="hidden">
                <?= $form->field($model, 'loadSubBlockSelect')->checkbox(['id' => 'loadSubBlockSelect-checkbox', 'class' => '']) ?>
            </div>

            <?= $form->field($model, 'work_plan_id')->widget(Select2::class, [
                'data' => WorkPlan::getList(),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select speciality'),
                ],
            ]) ?>

            <?= $model->student_id ? $form->field($model, 'subject_block_id')->widget(Select2::class, [
                'data' => SubjectBlock::getSubjectBlocksForStudent($model->student_id),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select ...'),
                    'onchange' => 'loadSubjectBlock(event)',
                ]
            ]) : '' ?>
            <!--  Hidden checkbox used with javaScript  -->
            <div class="hidden">
                <?= $form->field($model, 'loadSubjectBlock')->checkbox(['id' => 'loadSubjectBlock-checkbox', 'class' => '']) ?>
            </div>

            <?= /** @var SubjectBlock $subjectBlock */
            $model->subject_block_id ? DetailView::widget([
                'model' => $model->subjectBlock,
                'attributes' => $model->subjectBlock->getSubjectsDetail(),
            ]) : '' ?>


        </div>

    </div>

    <div class="form-group">

        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    var loadSubjectBlock = function (event) {
        var form = document.getElementById('student-plan-form');
        var request = document.getElementById('loadSubjectBlock-checkbox');
        request.checked = true;
        form.submit();
    };
    var loadSubBlockSelect = function (event) {
        var form = document.getElementById('student-plan-form');
        var request = document.getElementById('loadSubBlockSelect-checkbox');
        request.checked = true;
        form.submit();
    }
</script>



