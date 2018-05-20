<?php

/**
 * @var \app\modules\directories\models\StudyYear $year
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \app\modules\load\models\Load $model
 * @var \yii\bootstrap\ActiveForm $form
 * @var \yii\web\View $this
 */


use app\modules\directories\models\cyclic_commission\CyclicCommission;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

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
           $(sender).toggleClass("btn-warning");
       }
   ');
?>
<div class="well">
<h2>Навантаження на <?php echo $year->title; ?> навчальний рік</h2>

    <?php $form = ActiveForm::begin(['id' => 'load-filter-form', 'method' => 'GET']); ?>
    <?php echo $form->field($model, 'commissionId')->dropDownList(CyclicCommission::getList(), [
        'class' => 'span6',
        'empty' => '',
        'ajax' => [
            'type' => 'GET',
            'url' => Url::to('/teacher/listByCycle'), //url to call.
            'update' => '#Load_teacher_id',
            'data' => ['id' => 'js:this.value'],
        ],
    ]); ?>
<?php echo $form->field($model, 'teacher_id')->dropDownList([], ['empty' => '', 'class' => 'span6']); ?>
<div class="form-actions">
    <?php echo Html::submitButton('Фільтрувати', ['class' => 'btn-success']); ?>
    <?php echo Html::a(
        'Скасувати фільтр',
        Url::to('view', array('id' => $year->id)),
        array('class' => 'btn btn-danger')
    ); ?>
</div>
<?php ActiveForm::end(); ?>
<hr/>

<div class="form-actions">
    <button onclick="toggleSection('general', this)" class="btn btn-info">Загальні дані</button>
    <button onclick="toggleSection('fall', this)" class="btn btn-info">Осінній семестр</button>
    <button onclick="toggleSection('spring', this)" class="btn btn-info">Весняний семестр</button>
</div>

    <?= $this->render('_subjects', ['model' => $model, 'dataProvider' => $dataProvider]); ?>

</div>

