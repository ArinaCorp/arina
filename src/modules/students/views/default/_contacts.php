<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.03.2017
 * Time: 9:08
 */
/**
 * @var $modelsFamily \app\modules\students\models\FamilyTie[]
 */
use yii\bootstrap\Html;
use app\modules\students\models\FamilyTiesType;
use yii\widgets\MaskedInput;

?>
<div class="panel panel-default phones col-xs-6">
    <div class="panel-heading">
        <i class="fa fa-phone"></i> <?= Yii::t('app', 'Phones') ?>
        <button type="button" class="pull-right add-item btn btn-success btn-xs action-button"
                data-action="add-students-phone"><i
                    class="fa fa-plus"></i> <?= Yii::t('app', 'Add phone') ?></button>
        <div class="clearfix"></div>
    </div>
    <div class="panel-body container-items"><!-- widgetContainer -->
        <?php foreach ($modelsPhones as $index => $modelPhone): ?>
            <div class="item panel panel-default"><!-- widgetBody -->
                <div class="panel-heading">
                    <span class="panel-title-phone"><?= Yii::t('app', 'Phone') ?>: <?= ($index + 1) ?></span>
                    <button type="button"
                            class="pull-right remove-item btn btn-danger btn-xs action-button"
                            data-key="<?= $index ?>"
                            data-action="remove-students-phone"><i
                                class="fa fa-minus"></i></button>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <?php
                    // necessary for update action.
                    if (!$modelPhone->isNewRecord) {
                        echo Html::activeHiddenInput($modelPhone, "[{$index}]id");
                    }
                    ?>
                    <div class="row">
                        <div class="">
                            <?= $form->field($modelPhone, "[{$index}]phone")->textInput() ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="">
                            <?= $form->field($modelPhone, "[{$index}]comment")->textInput() ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="panel panel-default phones col-xs-6">
    <div class="panel-heading">
        <i class="fa fa-phone"></i> <?= Yii::t('app', 'Emails') ?>
        <button type="button" class="pull-right add-item btn btn-success btn-xs action-button"
                data-action="add-students-email"><i
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
                            data-action="remove-students-email"><i
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
                    <div class="row">
                        <div class="">
                            <?= $form->field($modelEmail, "[{$index}]email")->textInput() ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="">
                            <?= $form->field($modelEmail, "[{$index}]comment")->textInput() ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>