<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.03.2017
 * Time: 9:08
 */

/**
 * @var $modelsFamily \app\modules\students\models\FamilyRelation[]
 * @var $modelsPhones \app\modules\students\models\StudentsPhone[]
 * @var $modelsEmails \app\modules\students\models\StudentsEmail[]
 * @var $modelsSocials \app\modules\students\models\$modelsSocials[]
 */

use app\modules\students\models\SocialNetwork;
use yii\bootstrap\Html;
use app\modules\students\models\StudentsEmail;
use app\modules\students\models\StudentSocialNetwork;

?>
<div class="row">
    <div class="col-xs-4">
        <div class="panel panel-default phones ">
            <div class="panel-heading">
                <i class="fa fa-phone"></i> <?= Yii::t('app', 'Phones') ?>
                <button type="button" class="pull-right add-item btn btn-success btn-xs action-button"
                        data-action="add-students-phone">
                    <i class="fa fa-plus"></i>
                    <?= Yii::t('app', 'Add phone') ?>
                </button>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body container-items">
                <?php foreach ($modelsPhones as $index => $modelPhone): ?>
                    <div class="item panel panel-default">
                        <div class="panel-heading">
                            <span class="panel-title-phone"><?= Yii::t('app', 'Phone') ?>: <?= ($index + 1) ?></span>
                            <button type="button" class="pull-right remove-item btn btn-danger btn-xs action-button"
                                    data-key="<?= $index ?>"
                                    data-action="remove-students-phone">
                                <i class="fa fa-minus"></i>
                            </button>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php if (!$modelPhone->isNewRecord): ?>
                                <?= Html::activeHiddenInput($modelPhone, "[{$index}]id") ?>
                            <?php endif ?>

                            <div class="">
                                <?= $form->field($modelPhone, "[{$index}]phone")->textInput() ?>
                            </div>

                            <div class="">
                                <?= $form->field($modelPhone, "[{$index}]comment")->textInput() ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="panel panel-default phones">
            <div class="panel-heading">
                <i class="fa fa-phone"></i> <?= Yii::t('app', 'Emails') ?>
                <button type="button" class="pull-right add-item btn btn-success btn-xs action-button"
                        data-action="add-<?= StudentsEmail::shortClassName() ?>"><i
                            class="fa fa-plus"></i> <?= Yii::t('app', 'Add email') ?></button>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body container-items"><!-- widgetContainer -->
                <?php foreach ($modelsEmails as $index => $modelEmail): ?>
                    <div class="item panel panel-default"><!-- widgetBody -->
                        <div class="panel-heading">
                            <span class="panel-title-phone"><?= Yii::t('app', 'Email') ?>: <?= ($index + 1) ?></span>
                            <button type="button"
                                    class="pull-right remove-item btn btn-danger btn-xs action-button"
                                    data-key="<?= $index ?>"
                                    data-action="remove-<?= StudentsEmail::shortClassName() ?>"><i
                                        class="fa fa-minus"></i></button>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                            // necessary for update action.
                            if (!$modelEmail->isNewRecord) {
                                echo Html::activeHiddenInput($modelEmail, "[{$index}]id");
                            }
                            ?>
                            <div class="">
                                <?= $form->field($modelEmail, "[{$index}]email")->textInput() ?>
                            </div>
                            <div class="">
                                <?= $form->field($modelEmail, "[{$index}]comment")->textInput() ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="panel panel-default phones">
            <div class="panel-heading">
                <i class="fa fa-phone"></i> <?= Yii::t('app', 'Social networks') ?>
                <button type="button" class="pull-right add-item btn btn-success btn-xs action-button"
                        data-action="add-<?= StudentSocialNetwork::shortClassName() ?>"><i
                            class="fa fa-plus"></i> <?= Yii::t('app', 'Add network') ?></button>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body container-items">
                <?php foreach ($modelsSocials as $index => $modelSocial): ?>
                    <div class="item panel panel-default">
                        <div class="panel-heading">
                        <span class="panel-title-phone"><?= Yii::t('app', 'Social network') ?>
                            : <?= ($index + 1) ?></span>
                            <button type="button"
                                    class="pull-right remove-item btn btn-danger btn-xs action-button"
                                    data-key="<?= $index ?>"
                                    data-action="remove-<?= StudentSocialNetwork::shortClassName() ?>"><i
                                        class="fa fa-minus"></i></button>
                            <div class="clearfix"></div>
                        </div>
                        <div class="panel-body">
                            <?php
                            // necessary for update action.
                            if (!$modelSocial->isNewRecord) {
                                echo Html::activeHiddenInput($modelSocial, "[{$index}]id");
                            }
                            ?>
                            <div class="col-xs-12">
                                <?= $form->field($modelSocial, "[{$index}]network_id")->dropDownList(SocialNetwork::getList(), ['prompt' => Yii::t('app', 'Select') . ' ' . Yii::t('app', 'Social network')]); ?>
                            </div>
                            <div class="col-xs-12">
                                <?= $form->field($modelSocial, "[{$index}]url")->textInput() ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
