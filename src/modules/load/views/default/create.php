<?php

use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\web\View;
use kartik\select2\Select2;

use app\modules\directories\models\StudyYear;

/**
 * @var $this View
 */

$this->title = Yii::t('load', 'Load creating');

$this->params['breadcrumbs'][] = ['label' => Yii::t('load', 'Load'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4">
            <?= Select2::widget(
                [
                    'data' => StudyYear::getList(),
                    'id' => 'study_year',
                    'name' => 'study_year',
                    'options' =>
                        [
                            'placeholder' => Yii::t('load', 'Select study year')
                        ]
                ]
            );?>
        </div>
        <br/><br/>

    </div>

    <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>

    <?=Html::a(Yii::t('app', 'Return'), ['/load'], ['class' => 'btn btn-danger']) ?>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>

</div>
