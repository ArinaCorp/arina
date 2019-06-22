<?php

use app\modules\directories\models\speciality\Speciality;
use app\modules\directories\models\subject_block\SubjectBlock;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\modules\directories\models\subject\Subject;

/* @var $this View
 * @var $model SubjectBlock
 * @var $form ActiveForm
 */

?>

<div class="subject-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-sm-6">

            <?= $form->field($model, 'title')->input('string'); ?>

        </div>

    </div>

    <div class="form-group">

        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
