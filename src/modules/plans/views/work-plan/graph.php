<?php

use yii\web\View;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Html;

use app\modules\plans\models\WorkPlan;
use app\modules\plans\widgets\Graph;

/**
 * @var $this View
 * @var $model WorkPlan
 * @var $form ActiveForm
 */
$this->title = Yii::t('plans', 'Work plan graph generation');

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Work plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <h1><?= Html::encode($this->title); ?></h1>

    <h4><?= Html::encode($model->specialityQualification->title.' - '.$model->getYearTitle()); ?></h4>

    <h4><?= $model->getAttributeLabel('created').': '.\Yii::$app->formatter->asDate($model->created);  ?></h4>

    <?php Pjax::begin(); ?>

    <?php $form = ActiveForm::begin(
        [
            'id' => 'graph-form',
            'options' => [
                'enctype' => 'multipart/form-data',
            ],

        ]
    ); ?>

    <?php echo $form->errorSummary($model); ?>

    <?= Graph::widget(
        [
            'model' => $model,
            'field' => '',
            'graph' => $model->graph,
            'speciality_qualification_id' => $model->speciality_qualification_id,
            'study_year_id' => $model->study_year_id,
            'studyPlan' => false,
        ]
    );?>

    <?= $this->render('/_form_buttons', ['model' => $model, 'plan' => False]) ?>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end(); ?>
</div>