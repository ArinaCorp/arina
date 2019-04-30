<?php

use app\modules\directories\models\subject\Subject;
use app\modules\students\models\Group;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\accounting\models\AccountingMounth */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="accounting-mounth-form">



    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'teacher_id')->input('hidden', ['value' => Yii::$app->request->get('teacher_id')]) ?>
    <p>
        <?php //     Html::a(Yii::t('app', 'List'), ['index'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= $form->field($model, 'group_id')->widget(Select2::class,[
            'name' =>'select-group',
            'data' => Group::getActiveGroupsList(),
            'options' => [
                'placeholder' => Yii::t('app', 'Оберіть групу'),
            ],
            'pluginOptions' =>
                [
                    'allowClear' => true
                ]
    ]) ?>
    <?=$form->field($model, 'subject_id')->widget(Select2::class,[
        'name' =>'select-subject',
        'data' => Subject::getMap('title'),
        'options' => [
            'placeholder' => Yii::t('app', 'Оберіть предмет'),
        ],
        'pluginOptions' =>
            [
                'allowClear' => true
            ]
    ]) ?>



    <?= $form->field($model, 'date')->input('date') ?>
    <?= $form->field($model, 'hours')->textInput()  ?>

    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
