<?php
/**
 * @var PlanController $this
 * @var StudySubject $model
 * @var TbActiveForm $form
 */
?>
    <style>
        .input,
        .options {
            float: left;
        }

        .options input {
            float: left;
        }

        .options {
            margin: 15px 0 0 15px;
        }

        .options:after {
            content: '';
            display: block;
            clear: both;
        }

        .options .item {
            float: left;
            width: 75px;
        }

        .options .item.last {
            float: left;
            width: 130px;
            margin-right: -50px;
        }

        .span5 input[type="number"] {
            width: 170px;
        }

        #StudySubject_subject_id {
            width: 100%;
        }
    </style>
<?php $form = $this->beginWidget(BoosterHelper::FORM, array(
    'htmlOptions' => array(
        'class' => 'well row',
    )
)); ?>
    <h3>Редагування предмету <?php echo $model->subject->title; ?></h3>
<?php echo $form->errorSummary($model); ?>
    <div class="span3">
        <?php echo $form->dropDownListRow($model, 'subject_id',
            Subject::getListForSpeciality($model->plan->speciality_id)); ?>
        <?php echo $form->telFieldRow($model, 'diploma_name'); ?>
        <?php echo $form->telFieldRow($model, 'certificate_name'); ?>
    </div>
<div class="span3">
    <?php echo $form->numberFieldRow($model, 'total'); ?>
    <?php echo CHtml::label('Тижневі', 'classes_weeks'); ?>
    <?php echo CHtml::numberField('classes_weeks', '', array('placeholder' => 'Тижневі', 'readonly' => true)); ?>
    <?php echo CHtml::label('Аудиторні', 'classes'); ?>
    <?php echo CHtml::numberField('classes', '', array('placeholder' => 'Аудиторні', 'readonly' => true)); ?>
    <?php echo $form->numberFieldRow($model, 'lectures'); ?>
    <?php echo $form->numberFieldRow($model, 'labs'); ?>
    <?php echo $form->checkBoxRow($model, 'dual_labs'); ?>
    <?php echo $form->numberFieldRow($model, 'practs'); ?>
    <?php echo $form->checkBoxRow($model, 'dual_practice'); ?>
    <?php echo $form->numberFieldRow($model, 'practice_weeks'); ?>
</div>
    <div class="span5">
        <?php foreach ($model->plan->semesters as $semester => $weeks): ?>
            <div class="input">
                <?php echo CHtml::label($semester + 1 . '-й семестр: ' . $weeks . ' тижнів', 'StudySubject_weeks_' . $semester); ?>
                <?php echo $form->numberField($model, "weeks[$semester]", array('placeholder' => 'годин на тиждень')); ?>
            </div>
            <div class="options">
                <div class="item">
                    <?php echo $form->checkBox($model, "control[$semester][0]"); ?>
                    <?php echo CHtml::label(Yii::t('terms', 'Test'), "StudySubject_control_{$semester}_0"); ?>
                    <?php echo $form->checkBox($model, "control[$semester][1]"); ?>
                    <?php echo CHtml::label(Yii::t('terms', 'Exam'), "StudySubject_control_{$semester}_1"); ?>
                </div>
                <div class="item">
                    <?php echo $form->checkBox($model, "control[$semester][2]"); ?>
                    <?php echo CHtml::label(Yii::t('terms', 'DPA'), "StudySubject_control_{$semester}_2"); ?>
                    <?php echo $form->checkBox($model, "control[$semester][3]"); ?>
                    <?php echo CHtml::label(Yii::t('plan', 'DA'), "StudySubject_control_{$semester}_3"); ?>
                </div>
                <div class="item last">
                    <?php echo $form->checkBox($model, "control[$semester][4]"); ?>
                    <?php echo CHtml::label(Yii::t('terms', 'Course work'), "StudySubject_control_{$semester}_4"); ?>
                    <?php echo $form->checkBox($model, "control[$semester][5]"); ?>
                    <?php echo CHtml::label(Yii::t('terms', 'Course project'), "StudySubject_control_{$semester}_5"); ?>
                </div>
            </div>
            <div class="clearfix"></div>
        <?php endforeach; ?>
    </div>
    <div style="clear: both"></div>
    <div class="form-actions" style="width: 300px; margin: 0 auto">
        <?php echo CHtml::submitButton('Зберегти', array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::button('Очистити', array('type' => 'reset', 'class' => 'btn btn-danger')); ?>
        <?php echo CHtml::link('Повернутись', $this->createUrl('subjects', array('id' => $model->plan_id)), array('class' => 'btn btn-info')); ?>
    </div>
<?php $this->endWidget(); ?>

<script>
    var weeks = [
        <?php echo implode(', ', $model->plan->semesters); ?>
    ];

    function calcClasses(){
        var classes = 0;
        for (i = 0; i < 8; i++) {
            if ($("#StudySubject_weeks_" + i).val())
                classes += weeks[i] * parseInt($("#StudySubject_weeks_" + i).val());
        }
        $("#classes").val(classes);
    }


    $(function () {
        var selector = $('#StudySubject_lectures, #StudySubject_labs, #StudySubject_practs');

        function calcClasses() {
            selector.change(function () {
                var amount = 0;
                selector.each(function (i, e) {
                        var val = $(e).val();
                        if (val) amount += parseInt(val);
                    }
                );
                $('#classes').val(amount);
            })
        }
        calcClasses();

        $("input[id^='StudySubject_weeks_']").change(function () {
            calcClasses();
        });
    });
</script>