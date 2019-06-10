<?php

use app\modules\directories\models\StudyYear;
use app\modules\students\models\Student;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/** @var $this yii\web\View
 * @var $model \app\modules\students\models\StudentCard
 * @var $form ActiveForm
 */

$this->title = Yii::t('app', 'Student card');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="subject-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-sm-6">

            <?= $form->field($model, 'studentId')->widget(Select2::class, [
                'data' => Student::getList(),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select ...'),
                ],
            ]); ?>

            <?= $form->field($model, 'studyYearId')->widget(Select2::class, [
                'data' => StudyYear::getYearList(),
                'options' => [
                    'placeholder' => Yii::t('app', 'Select ...'),
                ],
            ]); ?>

        </div>

    </div>

    <div class="form-group">

        <?= Html::submitButton(Yii::t('app', 'Generate'), ['class' => 'btn btn-success']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
