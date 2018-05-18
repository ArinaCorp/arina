<?php

use yii\bootstrap\ActiveForm;

/** @var $this \yii\web\View */
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
                        </fieldset>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>