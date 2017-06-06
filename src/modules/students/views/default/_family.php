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
<div class="panel panel-default family">
    <div class="panel-heading">
        <i class="fa fa-users"></i> <?= Yii::t('app', 'Family') ?>
        <button data-action="add-family-tie" type="button"
                class="pull-right action-button add-item btn btn-success btn-xs"><i
                    class="fa fa-plus"></i> <?= Yii::t('app', 'Add ties') ?></button>
        <div class="clearfix"></div>
    </div>

    <div class="panel-body container-items"><!-- widgetContainer -->
        <?php foreach ($modelsFamily as $index => $modelFamily): ?>
            <div class="item panel panel-default"><!-- widgetBody -->
                <div class="panel-heading">
                    <span class="panel-title-address"><?= Yii::t('app', 'Family tie') ?>
                        : <?= ($index + 1) ?></span>
                    <button type="button" class="pull-right action-button remove-item btn btn-danger btn-xs"
                            data-key="<?= $index ?>"
                            data-action="remove-family-tie"><i
                                class="fa fa-minus"> </i></button>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <?php
                    // necessary for update action.
                    if (!$modelFamily->isNewRecord) {
                        echo Html::activeHiddenInput($modelFamily, "[{$index}]id");
                    }
                    ?>
                    <?= $form->field($modelFamily, "[{$index}]type_id")->dropDownList(FamilyTiesType::getList(), ['prompt' => Yii::t('app', 'Select') . ' ' . Yii::t('app', 'Family tie type')]); ?>

                    <div class="row">
                        <div class="col-sm-4">
                            <?= $form->field($modelFamily, "[{$index}]last_name")->textInput() ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($modelFamily, "[{$index}]first_name")->textInput() ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($modelFamily, "[{$index}]middle_name")->textInput() ?>
                        </div>
                    </div><!-- end:row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($modelFamily, "[{$index}]work_place")->textInput() ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($modelFamily, "[{$index}]work_position")->textInput() ?>
                        </div>
                    </div><!-- end:row -->

                    <div class="row">
                        <div class="col-sm-4">
                            <?= $form->field($modelFamily, "[{$index}]phone1")->textInput(['mask' => '(999) 999-9999']); ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($modelFamily, "[{$index}]phone2")->textInput(['mask' => '(999) 999-9999']); ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($modelFamily, "[{$index}]email")->textInput() ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>