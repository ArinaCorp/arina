<?php

use app\modules\directories\models\StudyYear;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/**
 * @var $this View
 */

$this->title = Yii::t('load', 'Load creating');

$this->params['breadcrumbs'][] = ['label' => Yii::t('load', 'Load'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="load-create">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Return'), ['/load'], ['class' => 'btn btn-danger']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4">
            <?= Select2::widget(
                [
                    'data' => StudyYear::getMap('title', 'id', null, false),
                    'id' => 'study_year',
                    'name' => 'study_year',
                    'options' => [
                        'placeholder' => Yii::t('load', 'Select study year')
                    ]
                ]
            ); ?>
        </div>
        <br/><br/>

    </div>

    <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>

</div>
