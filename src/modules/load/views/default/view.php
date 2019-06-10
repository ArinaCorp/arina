<?php

/**
 * @var \app\modules\directories\models\study_year\StudyYear $year
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \app\modules\load\models\LoadSearch $model
 * @var \yii\bootstrap\ActiveForm $form
 * @var \yii\web\View $this
 */


use app\modules\employee\models\CyclicCommission;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
//@TODO replace labels by Yii::t

//$this->breadcrumbs = array(
//    Yii::t('base', 'Load') => $this->createUrl('index'),
//    $year->title
//);

//$this->menu = array(
//    array(
//        'label' => 'Генерувати навантаження',
//        'url' => Url::to('generate', array('id' => $year->id)),
//        'type' => 'primary',
//    ),
//    array(
//        'label' => 'Розподілити курсові роботи, проекти',
//        'url' => Url::to('project', array('id' => $year->id)),
//        'type' => 'info'
//    ),
//    array(
//        'label' => 'Генерувати документ',
//        'url' => Url::to('doc', array('id' => $year->id)),
//        'type'=>'info',
//    ),
//);
$this->registerJs('
    window.toggleSection = function(section, sender) {
           $("."+section).toggle();
           $(sender).toggleClass("btn-info");
           $(sender).toggleClass("btn-default");
       }
   ');


$this->title = Yii::t('app', 'Loads');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="load-view">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Навантаження на <?php echo $year->title; ?> навчальний рік
            </h1>
        </div>
    </div>

    <?php $form = ActiveForm::begin(['id' => 'load-filter-form', 'method' => 'GET']) ?>

    <?php $employeeData = CyclicCommission::getEmployeeByCyclicCommissionMap($model->commission_id) ?>
    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'commission_id')
                ->widget(Select2::class, [
                    'data' => CyclicCommission::getMap('title'),
                    'id' => 'commissionId',
                    'options' => [
                        'placeholder' => Yii::t('app', 'Choose cyclic commission')
                    ],
                    'pluginOptions' => ['allowClear' => true],
                ]);
            ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'employee_id')->widget(DepDrop::class, [
                'data' => $employeeData,
                'type' => DepDrop::TYPE_SELECT2,
                'pluginOptions' => [
                    'depends' => ['loadsearch-commission_id'],
                    'url' => Url::to(['get-employees']),
                    'placeholder' => Yii::t('app', 'Choose employee'),
                ]
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Фільтрувати', ['class' => 'btn btn-success']); ?>

        <?= Html::a('Скасувати фільтр', Url::to('view', ['id' => $year->id]), ['class' => 'btn btn-danger']); ?>
    </div>
    <?php ActiveForm::end(); ?>

    <hr/>

    <div class="form-actions">
        <button onclick="toggleSection('general', this)" class="btn btn-info">Загальні дані</button>
        <button onclick="toggleSection('fall', this)" class="btn btn-info">Осінній семестр</button>
        <button onclick="toggleSection('spring', this)" class="btn btn-info">Весняний семестр</button>
    </div>

    <p>
        <?= $this->render('_subjects', ['model' => $model, 'dataProvider' => $dataProvider]); ?>
    </p>

</div>

