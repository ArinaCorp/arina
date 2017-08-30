<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel \app\modules\directories\models\speciality_qualification\SpecialityQualificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Speciality Qualifications');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speciality-qualification-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Speciality Qualification'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php $form = \yii\widgets\ActiveForm::begin() ?> ?>
    <?= \kartik\select2\Select2::widget([
        'name' => 'year_id',
        'data' => \app\modules\directories\models\StudyYear::getYearList(),
    ]); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php \yii\widgets\ActiveForm::end() ?>
</div>
