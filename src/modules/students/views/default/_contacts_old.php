<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.03.2017
 * Time: 9:08
 */

/**
 * @var \app\modules\students\models\Student $model
 */

use app\modules\students\models\SocialNetwork;
use app\modules\students\models\StudentSocialNetwork;
use app\widgets\DynamicFormWidget;
use yii\bootstrap\Html;

?>
<div class="row">
    <div class="col-xs-4">

        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'phone_wrapper',
            'widgetBody' => '.container-items-phone',
            'widgetItem' => '.item-phone',
            'limit' => 4,
            'min' => 0,
            'insertButton' => '.add-item-phone',
            'deleteButton' => '.remove-item-phone',
            'model' => $model->phonesList[0],
            'formId' => 'studentForm',
            'formFields' => [
                'phone',
                'comment',
            ],
        ]); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-phone"></i> <?= Yii::t('app', 'Phones') ?>
                <button type="button" class="pull-right add-item-phone btn btn-success btn-xs "
                        data-action="add-students-phone">
                    <i class="fa fa-plus"></i>
                    <?= Yii::t('app', 'Add phone') ?>
                </button>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body container-items-phone">
                <?php foreach ($model->phonesList as $index => $modelPhone): ?>
                    <div class="item-phone panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="pull-right remove-item-phone btn btn-danger btn-xs "
                                    data-key="<?= $index ?>">
                                <i class="fa fa-minus"></i>
                            </button>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php if (!$modelPhone->isNewRecord): ?>
                                <?= Html::activeHiddenInput($modelPhone, "[{$index}]id") ?>
                            <?php endif ?>
                            <div>
                                <?= $form->field($modelPhone, "[{$index}]phone")->textInput() ?>
                            </div>

                            <div>
                                <?= $form->field($modelPhone, "[{$index}]comment")->textInput() ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php DynamicFormWidget::end(); ?>
    </div>
    <div class="col-xs-4">

        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'email_wrapper',
            'widgetBody' => '.container-items-email',
            'widgetItem' => '.item-email',
            'limit' => 4,
            'min' => 0,
            'insertButton' => '.add-item-email',
            'deleteButton' => '.remove-item-email',
            'model' => $model->emailsList[0],
            'formId' => 'studentForm',
            'formFields' => [
                'email',
                'comment',
            ],
        ]); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-phone"></i> <?= Yii::t('app', 'Emails') ?>
                <button type="button" class="pull-right add-item-email btn btn-success btn-xs">
                    <i class="fa fa-plus"></i>
                    <?= Yii::t('app', 'Add email') ?>
                </button>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body container-items-email">
                <?php foreach ($model->emailsList as $index => $modelEmail): ?>
                    <div class="item-email panel panel-default">
                        <div class="panel-heading">
                            <button type="button" class="pull-right remove-item-email btn btn-danger btn-xs">
                                <i class="fa fa-minus"></i>
                            </button>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php if (!$modelEmail->isNewRecord): ?>
                                <?= Html::activeHiddenInput($modelEmail, "[{$index}]id"); ?>
                            <?php endif ?>
                            <div>
                                <?= $form->field($modelEmail, "[{$index}]email")->textInput() ?>
                            </div>
                            <div>
                                <?= $form->field($modelEmail, "[{$index}]comment")->textInput() ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php DynamicFormWidget::end(); ?>
    </div>
    <div class="col-xs-4">
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'social_wrapper',
            'widgetBody' => '.container-items-social',
            'widgetItem' => '.item-social',
            'limit' => 4,
            'min' => 0,
            'insertButton' => '.add-item-social',
            'deleteButton' => '.remove-item-social',
            'model' => $model->socialNetworksList[0],
            'formId' => 'studentForm',
            'formFields' => [
                'network_id',
                'url',
            ],
        ]); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-phone"></i> <?= Yii::t('app', 'Social networks') ?>
                <button type="button" class="pull-right add-item-social btn btn-success btn-xs"
                <i class="fa fa-plus"></i>
                <?= Yii::t('app', 'Add network') ?>
                </button>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body container-items-social">
                <?php foreach ($model->socialNetworksList as $index => $modelSocial): ?>
                    <div class="item-social panel panel-default">
                        <div class="panel-heading">
                            <button type="button"
                                    class="pull-right remove-item-social btn btn-danger btn-xs "
                                    data-action="remove-<?= StudentSocialNetwork::shortClassName() ?>"><i
                                        class="fa fa-minus"></i></button>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php if (!$modelSocial->isNewRecord) : ?>
                                <?php Html::activeHiddenInput($modelSocial, "[{$index}]id"); ?>
                            <?php endif ?>
                            <div class="col-xs-12">
                                <?= $form->field($modelSocial, "[{$index}]network_id")->dropDownList(SocialNetwork::getMap('title'), ['prompt' => Yii::t('app', 'Select') . ' ' . Yii::t('app', 'Social network')]); ?>
                            </div>
                            <div class="col-xs-12">
                                <?= $form->field($modelSocial, "[{$index}]url")->textInput() ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php DynamicFormWidget::end(); ?>
    </div>
</div>
