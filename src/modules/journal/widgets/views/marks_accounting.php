<?php
/**
 * Created by PhpStorm.
 * User: vyach
 * Date: 30.04.2019
 * Time: 13:31
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var integer $load_id
 * @var array $loads
 * @var array $dates
 * @var array $students
 */

?>
<?php
$actionUrl = Url::to(['site/index']);

$this->registerJS(<<<JS
    $('#load_select').on('change', function(){
        $.pjax.reload({
            container: '#marks-accounting-widget', 
            url: '$actionUrl', 
            data: {
                load_id: $(this).val()
            }
        })
    });
JS
);
?>

<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'load_id')->widget(Select2::class, [
        'options' => [
            'id' => 'load_select'
        ],
        'data' => $loads,
        'pluginOptions' => [
            'placeholder' => Yii::t('journal', 'Choose subject')
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Selecting'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <p>
        <?= Html::button(Yii::t('app', 'Add column'), ['class' => 'btn btn-success', 'data-toggle' => 'modal', 'data-target' => '#addColumnModal']) ?>
    </p>

    <div class="modal fade" id="addColumnModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <?= Html::button(Yii::t('app', 'Cancel'), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
                    <?= Html::a(Yii::t('app', 'Save'), ['journal/marks-accounting/create', 'load_id' => $load_id], ['class' => 'btn btn-success', 'id' => 'add_column']); ?>
                </div>
            </div>
        </div>
    </div>

    <?php Pjax::begin([
        'id' => 'marks-accounting-widget'
    ]); ?>

    <table class="table table-striped table-condensed table-bordered table-hover">
        <thead>
        <tr>
            <th><?= Yii::t('app', 'Student'); ?></th>
            <?php foreach ($dates as $date): ?>
                <th>
                    <div>
                        <?= $date->date ?>
                        <button data-pjax="0" class="pull-right remove-item btn btn-danger btn-xs">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </th>
            <?php endforeach ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?= $student->getShortName(); ?></td>
                <?php foreach ($dates as $date): ?>
                    <td></td>
                <?php endforeach ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php Pjax::end(); ?>
</div>

