<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\students\models\Student;
use app\modules\students\models\Group;
use kartik\depdrop\DepDrop;
use app\modules\students\models\StudentsHistory;
use yii\helpers\Url;
use app\modules\students\models\Exemption;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\students\models\ExemptionStudentRelation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="exemption-student-relation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group_id')->widget(Select2::className(),
        [
            'data' => Group::getActiveGroupsList(),
            'pluginOptions' => [
                'placeholder' => Yii::t('app', 'Select group'),
                'allowClear' => true
            ],
            'options' => [
                'id' => 'group_id',
            ]
        ]
    ); ?>

    <?= $form->field($model, 'student_id')->widget(DepDrop::className(),
        [
            'data' => StudentsHistory::getActiveStudentByGroupList($model->group_id),
            'pluginOptions' => [
                'depends' => ['group_id'],
                'placeholder' => Yii::t('app', 'Select student'),
                'url' => Url::to(['get-students-list']),
                'loadingText' => Yii::t('app', 'Loading ...'),
            ],
            'options' => ['placeholder' => 'Select group'],
            'type' => DepDrop::TYPE_SELECT2,
            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
        ]
    ); ?>

    <?= $form->field($model, 'exemption_id')->widget(Select2::className(), [
        'data' => Exemption::getList(),
        'pluginOptions' => [
            'placeholder' => Yii::t('app', 'Select exemption')
        ]
    ]) ?>

    <?= $form->field($model, 'date_start')->widget(DatePicker::className()) ?>

    <?= $form->field($model, 'date_end')->widget(DatePicker::className()) ?>

    <?= $form->field($model, 'information')->textarea(['maxlength' => true, 'rows' => 2]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
