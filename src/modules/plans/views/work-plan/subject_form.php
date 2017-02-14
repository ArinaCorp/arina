<?php
/**
 * @var WorkController $this
 * @var WorkSubject $model
 * @var WorkPlan $plan
 * @var TbActiveForm $form
 */
$this->breadcrumbs = array(
    'Робочі плани' => $this->createUrl('index'),
    $model->plan->speciality->title . ': ' . $model->plan->year->title => $this->createUrl(
            'subjects',
            array('id' => $model->plan_id)
        ),
);
?>

<style>
    .controls div {
        float: left;
        width: 160px;
    }

    .row {
        margin-right: -50px;
    }

    .line hr {
        border-color: #808080;
        height: 2px;
        width: 82%;
    }

    .semester {
        margin-top: 10px;
    }
</style>
<div>
    <?php $form = $this->beginWidget(
        BoosterHelper::FORM,
        array(
            'id' => 'add_subject',
            'htmlOptions' => array('class' => 'well')
        )
    ); ?>
    <h2><?php echo $model->isNewRecord ? 'Додання' : 'Редагування'; ?> предмету
        <?php echo !$model->isNewRecord ? $model->subject->title : ''; ?></h2>

    <div class="row">
        <div class="span5">

            <?php echo CHtml::label('Цикл', 'cycle'); ?>
            <?php echo CHtml::dropDownList(
                'cycle',
                '',
                SubjectCycle::getList(),
                array(
                    'class' => 'span5',
                    'empty' => '',
                    'ajax' => array(
                        'type' => 'GET',
                        'url' => CController::createUrl(
                                '/subject/listBySpeciality',
                                array('id' => $plan->speciality_id)
                            ), //url to call.
                        'update' => '#WorkSubject_subject_id',
                        'data' => array('cycle_id' => 'js:this.value'),
                    )
                )
            ); ?>
            <?php echo $form->dropDownListRow($model, 'subject_id', array(), array('class' => 'span5')); ?>
        </div>
        <div class="span7">

            <?php echo $form->dropDownListRow(
                $model,
                'cyclic_commission_id',
                CyclicCommission::getList(),
                array('class' => 'span6')
            ); ?>
        </div>

        <div class="span3">

            <?php echo $form->textFieldRow($model, 'certificate_name', array('class' => 'span3')); ?>
        </div>
        <div class="span3">

            <?php echo $form->textFieldRow($model, 'diploma_name', array('class' => 'span3')); ?>
        </div>
    </div>
    <hr/>
    <div class="row">
        <div class="span6">
            Загальна кількість в навчальному
            плані: <?php echo isset($model->control_hours['total']) ? $model->control_hours['total'] : 'невказано'; ?>
        </div>
        <div class="span6">
            <?php echo $form->numberFieldRow($model, 'project_hours'); ?>
        </div>
    </div>
    <div class="row">
        <?php for ($i = 0; $i < 8; $i++): ?>
            <div class="span6 semester" id="semester_<?php echo $i; ?>">
                <h4><?php echo $i + 1; ?>-й семестр: <?php echo $model->plan->semesters[$i]; ?> тижнів (<span
                        class="total">0</span> год.)</h4>

                <div class="hours">
                    <div>
                        <?php echo $form->numberField(
                            $model,
                            "total[$i]",
                            array('placeholder' => 'Загальна кількість', 'style' => 'width:140px')
                        ); ?>
                        <?php echo CHtml::numberField(
                            "classes_$i",
                            '',
                            array('placeholder' => 'Аудиторні', 'readonly' => true, 'style' => 'width:140px')
                        ); ?>
                        <?php echo $form->numberField(
                            $model,
                            "weeks[$i]",
                            array('placeholder' => 'Годин на тиждень', 'style' => 'width:140px')
                        ); ?>
                    </div>
                    <div class="second_section">
                        <?php echo $form->numberField(
                            $model,
                            "lectures[$i]",
                            array('placeholder' => 'Лекції', 'style' => 'width:140px')
                        ); ?>
                        <?php echo $form->numberField(
                            $model,
                            "labs[$i]",
                            array('placeholder' => 'Лабораторні', 'style' => 'width:140px')
                        ); ?>
                        <?php echo $form->numberField(
                            $model,
                            "practs[$i]",
                            array('placeholder' => 'Практичні', 'style' => 'width:140px')
                        ); ?>
                    </div>
                </div>
                <div class="controls">
                    <div>
                        <?php echo $form->checkBoxRow($model, "control[$i][0]", array(), array('label' => 'Залік')); ?>
                        <?php echo $form->checkBoxRow(
                            $model,
                            "control[$i][1]",
                            array(),
                            array('label' => 'Екзамен')
                        ); ?>
                    </div>
                    <div>
                        <?php echo $form->checkBoxRow($model, "control[$i][2]", array(), array('label' => 'ДПА')); ?>
                        <?php echo $form->checkBoxRow($model, "control[$i][3]", array(), array('label' => 'ДА')); ?>
                    </div>
                    <div>
                        <?php echo $form->checkBoxRow(
                            $model,
                            "control[$i][4]",
                            array(),
                            array('label' => 'Курсова робота')
                        ); ?>
                        <?php echo $form->checkBoxRow(
                            $model,
                            "control[$i][5]",
                            array(),
                            array('label' => 'Курсовий проект')
                        ); ?>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="line">
                    <hr/>
                </div>
            </div>
        <?php endfor; ?>
    </div>

    <?php $this->renderPartial('//formButtons', array('model' => $model)); ?>
    <?php $this->endWidget(); ?>
</div>
<script>
    var weeks = [<?php echo implode(', ',$model->plan->semesters);?>];

    function calcClasses() {
        for (i = 0; i < 8; i++) {
            if ($("#WorkSubject_weeks_" + i).val()) {
                $("#semester_" + i+' span.total').html(weeks[i] * parseInt($("#WorkSubject_weeks_" + i).val()));
            }
        }
    }

    $(function () {
        calcClasses();

        $("input[id^='WorkSubject_weeks_']").change(function () {
            calcClasses();
        });

        $("div[id^=semester_]").each(function (i, ee) {
            var inputs = $(ee).find('.second_section input');
            inputs.change(function (e) {
                var total = $(ee).find('input[id^="classes"]');
                var amount = 0;
                inputs.each(function (i, e) {
                    var val = $(e).val();
                    if (val) amount += parseInt(val);
                });
                total.val(amount);
            });
        });
    });
</script>
