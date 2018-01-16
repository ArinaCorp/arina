<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11.03.2017
 * Time: 9:08
 */

/**
 * @var \yii\web\View $this
 * @var \app\modules\students\models\Student $model
 */

use app\assets\DynamicFormAsset;
use app\modules\students\models\StudentsEmail;
use app\modules\students\models\StudentsPhone;
use app\modules\students\models\StudentSocialNetwork;

DynamicFormAsset::register($this);

$this->registerJs(<<<JS
jQuery('#EmailForm').dynamicForm();
jQuery('#PhoneForm').dynamicForm();
jQuery('#SocialNetworkForm').dynamicForm();
JS
);
?>
<div class="row">
    <div class="col-md-4">

        <div class="panel panel-default" id="EmailForm">
            <div class="panel-heading">
                <i class="fa fa-envelope"></i> <?= Yii::t('app', 'E-mails') ?>
                <button data-pjax="0" class="pull-right add-item btn btn-success btn-xs">
                    <i class="fa fa-plus"></i>
                    <?= Yii::t('app', 'Add email') ?>
                </button>
                <div class="clearfix"></div>
            </div>

            <div class="panel-body items">
                <div class="form-template">
                    <?= $this->render('_email_item', [
                        'model' => new StudentsEmail(),
                        'form' => $form,
                        'index' => 'new_ITEM_INDEX',
                    ]) ?>
                </div>
                <?php foreach ($model->emailsList as $index => $modelStudentsEmail): ?>
                    <?= $this->render('_email_item', [
                        'model' => $modelStudentsEmail,
                        'form' => $form,
                        'index' => $index,
                    ]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default" id="PhoneForm">
            <div class="panel-heading">
                <i class="fa fa-phone"></i> <?= Yii::t('app', 'Phones') ?>
                <button data-pjax="0" class="pull-right add-item btn btn-success btn-xs">
                    <i class="fa fa-plus"></i>
                    <?= Yii::t('app', 'Add phone') ?>
                </button>
                <div class="clearfix"></div>
            </div>

            <div class="panel-body items">
                <div class="form-template">
                    <?= $this->render('_phone_item', [
                        'model' => new StudentsPhone(),
                        'form' => $form,
                        'index' => 'new_ITEM_INDEX',
                    ]) ?>
                </div>
                <?php foreach ($model->phonesList as $index => $modelStudentsPhones): ?>
                    <?= $this->render('_phone_item', [
                        'model' => $modelStudentsPhones,
                        'form' => $form,
                        'index' => $index,
                    ]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default" id="SocialNetworkForm">
            <div class="panel-heading">
                <i class="fa fa-users"></i> <?= Yii::t('app', 'Social networks') ?>
                <button data-pjax="0" class="pull-right add-item btn btn-success btn-xs">
                    <i class="fa fa-plus"></i>
                    <?= Yii::t('app', 'Add network') ?>
                </button>
                <div class="clearfix"></div>
            </div>

            <div class="panel-body items">
                <div class="form-template">
                    <?= $this->render('_social_network_item', [
                        'model' => new StudentSocialNetwork(),
                        'form' => $form,
                        'index' => 'new_ITEM_INDEX',
                    ]) ?>
                </div>
                <?php foreach ($model->socialNetworksList as $index => $modelStudentsSocialNetwork): ?>
                    <?= $this->render('_social_network_item', [
                        'model' => $modelStudentsSocialNetwork,
                        'form' => $form,
                        'index' => $index,
                    ]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>