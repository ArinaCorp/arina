<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $model \nullref\admin\models\LoginForm */

$this->title = Yii::t('admin', 'Sign in');
?>
<div class="main-login">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= Yii::t('admin', 'Please Sign In') ?></h3>
                    </div>
                    <div class="panel-body">
                        <?php $form = ActiveForm::begin(); ?>
                        <fieldset>

                            <?= $form->field($model, 'username', [
                                'template' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>{input}</div>{hint}{error}'
                            ])->textInput([
                                'placeholder' => ArrayHelper::getValue($model->attributeLabels(), 'username')
                            ]); ?>

                            <?= $form->field($model, 'password', [
                                'template' => '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>{input}</div>{hint}{error}'
                            ])->passwordInput([
                                'placeholder' => ArrayHelper::getValue($model->attributeLabels(), 'password')
                            ]); ?>

                            <?= $form->field($model, 'rememberMe', [
                                'template' => '<div class="checkbox"><label>{input}</label></div>'
                            ])->checkbox() ?>


                            <div class="form-group">
                                <?= Html::submitButton(Yii::t('admin', 'Sign in'),
                                    ['class' => 'btn btn-lg btn-primary btn-block']) ?>
                            </div>
                        </fieldset>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>