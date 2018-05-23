<?php
/**
 * @var \yii\web\View $this
 * @var \app\modules\load\models\Load $model
 * @var ActiveForm $form
 */

use app\modules\directories\models\cyclic_commission\CyclicCommission;
use app\modules\employee\models\Teacher;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

//$this->breadcrumbs = array(
//    Yii::t('base', 'Load') => $this->createUrl('index'),
//    $model->studyYear->title => $this->createUrl('view', array('id' => $model->study_year_id)),
//    $model->planSubject->subject->title . ' для ' . $model->group->title
//);

//$this->title = Yii::t('load', 'Loads');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(); ?>

<div class="load-update">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= $model->workSubject->subject->title . ' для ' . $model->group->title; ?>
            </h1>
        </div>
    </div>

    <?php
    $employeeData = CyclicCommission::getEmployeeByCyclicCommissionMap($model->workSubject->cyclic_commission_id);
    ?>

    <?= $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-5">
            <?= $form->field($model, 'commissionId')
                ->widget(Select2::class, [
                    'data' => CyclicCommission::getList(),
                    'id' => 'commissionId',
                    'options' => [
                        'placeholder' => Yii::t('app', 'Choose cyclic commission')
                    ],
                    'pluginOptions' => ['allowClear' => true],
                ]);
            ?>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-5">
            <?= $form->field($model, 'employee_id')->widget(DepDrop::class, [
                'data' => $employeeData,
                'type' => DepDrop::TYPE_SELECT2,
                'pluginOptions' => [
                    'depends' => ['load-commissionid'],
                    'url' => Url::to(['get-employees']),
                    'placeholder' => Yii::t('app', 'Choose employee'),
                ]
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <h3 class="central-header">Осінній семестр</h3>
            <?= $form->field($model, 'fall_hours[0]')->textInput(); ?>
            <?= $form->field($model, 'fall_hours[1]')->textInput(); ?>
            <?= $form->field($model, 'consult[0]')->textInput(); ?>
        </div>
        <div class="col-sm-3">
            <h3 class="central-header">Весняний семестр</h3>
            <?= $form->field($model, 'spring_hours[0]')->textInput(); ?>
            <?= $form->field($model, 'spring_hours[1]')->textInput(); ?>
            <?= $form->field($model, 'consult[1]')->textInput(); ?>
        </div>
    </div>
    <div class="form-actions">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']) ?>
<!--        --><?//= Html::resetButton(Yii::t('app', 'Cancel')); ?>
        <?= Html::a('Повернутись', Yii::$app->request->getReferrer(), ['class' => 'btn btn-danger']); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>