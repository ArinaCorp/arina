<?php

use app\modules\rbac\models\ActionReader;
use kartik\depdrop\DepDrop;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model app\modules\rbac\models\ActionAccess
 * @var $form yii\widgets\ActiveForm
 */

$reader = new ActionReader();
$modules = $reader->getModules();

?>

<div class="Action-access-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'module')->dropDownList($modules, [
        'prompt' => Yii::t('rbac', 'Choose module'),
    ]) ?>

    <?= $form->field($model, 'controller')->widget(DepDrop::class, [
        'options' => ['id' => 'controller'],
        'value' => $model->controller,
        'pluginOptions' => [
            'depends' => [Html::getInputId($model, 'module')],
            'placeholder' => Yii::t('rbac', 'Choose controller'),
            'url' => Url::to(['/rbac/access/controllers'])
        ]
    ]); ?>

    <?= $form->field($model, 'action')->widget(DepDrop::class, [
        'options' => ['id' => 'action'],
        'value' => $model->action,
        'pluginOptions' => [
            'depends' => [Html::getInputId($model, 'module'), 'controller'],
            'placeholder' => Yii::t('rbac', 'Choose action'),
            'url' => Url::to(['/rbac/access/actions'])
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('rbac', 'Create') : Yii::t('rbac', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
