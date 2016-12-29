<?php
/**
 * @author VasyaKog
 */

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model \app\modules\students\models\File */

/* @author VasyaKog */

$this->title = Yii::t('app', 'Import Students from XML');
$this->params['breadcrumbs'][] = Yii::t('app', 'Students');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="subject-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?php $form = \yii\widgets\ActiveForm::begin([
            'options' => [
                'enctype' => 'multipart/form-data'
            ],
        ]
    ); ?>
    <?= $form->field($model, 'file')->fileInput(); ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Import'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>
</div>
