<?php
/**
 * Created by IntelliJ IDEA.
 * User: vladi
 * Date: 22.03.2019
 * Time: 18:46
 */
/* @var $search app\modules\students\models\Student */

/* @var $student app\modules\students\models\Student */

use app\modules\directories\models\department\Department;
use app\modules\students\models\Group;
use app\modules\students\models\Student;
use kartik\depdrop\DepDrop;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use \kartik\select2\Select2;
use \app\modules\students\models\StudentsHistory;
use kartik\checkbox\CheckboxX;
use \app\modules\students\models\Exemption;
use \app\modules\directories\models\speciality\Speciality;

?>

<?php
$this->registerJs(
    '$("document").ready(function(){
            $("#new_filter").on("pjax:end", function() {
            $.pjax.reload({container:"#notes"});  //Reload GridView
        });
    });'
);
?>

    <div class="form">
        <!--        --><?php //yii\widgets\Pjax::begin(['id' => 'new_filter']) ?>
        <?php $form = ActiveForm::begin([
            'options' => ['data-pjax' => true],
            'action' => ['filter'],
            'method' => 'get',
        ]); ?>

        <hr>
        <div class="row">
            <div class="col-sm-4">Всього студентів: <span
                        class="float-right"><?= count(StudentsHistory::getActiveStudentsList()) ?></span></div>
            <div class="col-sm-4">Б`юджетні: <span
                        class="float-right"><?= count(StudentsHistory::getStateStudentsList()) ?></span></div>
            <div class="col-sm-4">Платні: <span
                        class="float-right"><?= count(StudentsHistory::getContractStudentsList()) ?></span></div>
        </div>
        <hr>
        <!-- firstRow -->
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <?= $form->field($search, 'last_name') ?>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <?= $form->field($search, 'first_name') ?>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <?= $form->field($search, 'middle_name') ?>
                </div>
            </div>
        </div>
        <!-- seccondRow -->
        <div class="row">
            <div class="col-sm-4">
                <div class="thumbnail" style="padding: 5px 20px;">
                    <h4 class="text-center"><b><?= Yii::t('app', 'Location') ?></b></h4>
                    <hr style="margin-top: 0">
                    <div class="form-group">
                        <div class="form-group">
                            <?= $form->field($search, 'department')->widget(Select2::classname(), [
                                'data' => Department::getMap('title'),
                                'pluginOptions' => [
                                    'placeholder' => Yii::t('app', 'Select department'),
                                    'allowClear' => true
                                ],
                                'options' => [
                                    'id' => 'department-id'

                                ]
                            ])->label(Yii::t('app', 'Department')); ?>
                        </div>
                        <?= $form->field($search, 'speciality')->widget(DepDrop::className(), [
                            'data' => Speciality::getList(),
                            'pluginOptions' => [
                                'depends' => ['department-id'],
                                'placeholder' => Yii::t('app', 'Select speciality'),
                                'url' => Url::to(['speciality-list']),
                            ],
                            'type' => DepDrop::TYPE_SELECT2,
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'options' => [
                                'id' => 'spec-id',
                                'placeholder' => 'Select ...'
                            ]
                        ])->label(Yii::t('app', 'Speciality')) ?>
                    </div>
                    <div class="form-group">
                        <?= $form->field($search, 'group')->widget(DepDrop::className(), [
                            'data' => Group::getAllGroupsList(),
                            'options' => [
                                'id' => 'group-id',
                                'placeholder' => 'Select ...'
                            ],
                            'pluginOptions' => [
                                'depends' => ['spec-id', 'department-id'],
                                'placeholder' => Yii::t('app', 'Select group'),
                                'url' => Url::to(['group-list']),
                                'loadingText' => Yii::t('app', 'Loading ...'),
                            ],
                            'type' => DepDrop::TYPE_SELECT2,
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],

                        ])->label(Yii::t('app', 'Group')) ?>
                    </div>
                    <!--                    --><? //= $form->field($search, 'excluded')->checkbox([
                    //                        'label' => Yii::t('app', 'Excluded'),
                    //                    ]) ?>

                    <?= $form->field($search, 'active')->checkbox([
                        'label' => Yii::t('app', 'Active'),
                    ]) ?>
                    <?= $form->field($search, 'released')->checkbox([
                        'label' => Yii::t('app', 'Released'),
                    ]) ?>
                    <?= $form->field($search, 'renewal')->checkbox([
                        'label' => Yii::t('app', 'Renewal'),
                    ]) ?>

                    <!--                    --><? //= $form->field($search, 'academic')->checkbox([
                    //                        'label' => Yii::t('app', 'Academic leave'),
                    //                    ]) ?>
                </div>

            </div>

            <div class="col-sm-8">
                <div class="thumbnail" style="padding: 5px 30px;">
                    <h4 class="text-center"><b><?= Yii::t('app', 'Exemptions') ?></b></h4>
                    <hr style="margin-top: 0">
                    <div class="row">

                        <?php
                        $exemptions = ArrayHelper::map(Exemption::find()->all(), 'id', 'title');
                        echo $form->field($search, 'exemptions')->checkboxList($exemptions, [
                            'item' => function ($index, $label, $name, $checked, $value) {
                                return '
                                <div class="col-md-6 col-lg-4">
                                <div class="form-group ">
                                ' . Html::checkbox($name, $checked, ['label' => $label, 'value' => $value]) . '
                                </div></div>
                            ';
                            }])->label(false);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="thumbnail text-center">
                    <h4><b><?= $form->field($search, "payment")->widget(CheckboxX::className(), [
                                'name' => 'payment',
                                'options' => ['id' => 'payment'],
                                'pluginOptions' => ['threeState' => false]
                            ])->label(Yii::t('app', 'Payment')) ?></b></h4>
                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                            echo SwitchInput::widget([
                                'model' => $search,
                                'attribute' => 'state_payment',
                                'pluginOptions' => [
                                    'onText' => Yii::t('app', 'State payment'),
                                    'offText' => Yii::t('app', 'Contract payment'),
                                    'animate' => false,
                                    'onColor' => 'success',
                                    'offColor' => 'danger']
                            ])
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group" style="text-align: right">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Reset'), ['filter'], ['class' => 'btn btn-default']) ?>
        <?= Html::a(Yii::t('app', 'Excel'), ['default/document', 'params' => Yii::$app->request->queryParams], ['class' => 'btn btn-success']) ?>
    </div>
<?php ActiveForm::end(); ?>
<?php //\yii\widgets\Pjax::end();
