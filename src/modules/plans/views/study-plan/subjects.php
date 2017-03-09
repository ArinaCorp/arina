<?php

use yii\web\View;
use yii\bootstrap\ActiveForm;
use yii\widgets\Pjax;
use yii\bootstrap\Html;
use kartik\select2\Select2;

use app\modules\plans\models\StudySubject;
use app\modules\plans\models\StudyPlan;

/**
 * @var $this View
 * @var $model StudySubject
 * @var $form ActiveForm
 */

$this->title = Yii::t('plans', 'Edit study plan');

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Study plans'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->study_plan->speciality->title, 'url' => ['plans/study-plan/view', ['id' => $model->plan_id]]];
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
    .input,
    .options {
        float: left;
    }

    .options input {
        float: left;
    }

    .options {
        margin: 15px 0 0 15px;
    }

    .options:after {
        content: '';
        display: block;
        clear: both;
    }

    .options .item {
        float: left;
        width: 75px;
    }

    .options .item.last {
        float: left;
        width: 130px;
        margin-right: -50px;
    }

    .span5 input[type="number"] {
        width: 170px;
    }
</style>

<?php Pjax::begin(); ?>

<?php $form = ActiveForm::begin(
    [
        'id' => 'dynamic-form',
        'options' => [
            'enctype' => 'multipart/form-data',
        ],

    ]
); ?>

<h3>Додання предметів</h3>
<?= $form->errorSummary($model); ?>

<div class="span3">
    <?php var_dump(StudyPlan::findOne(['id' => $model->id]));?>
    <?= $form->field($model, 'speciality_id')->widget(Select2::className(), [
        'data' => StudyPlan::findOne(['id' => $model->id])->getUnusedSubjects(),
        'options' =>
            [
                'placeholder' => Yii::t('plans', 'Select subject')
            ]
    ]);?>
</div>
