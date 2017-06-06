<?php
/**
 * @var CActiveDataProvider $dataProvider
 * @var integer $course
 * @var WorkPlan $model
 */
?>

    <div class="tab-content">
        <table class="table table-bordered">
            <tr>
                <th rowspan="4"></th>
                <th rowspan="4">Предмет</th>
                <th rowspan="4">Викладач</th>
                <th rowspan="4" class="general">Курс</th>
                <th rowspan="4">Група</th>
                <th rowspan="2" colspan="3" class="general">Кількість студентів</th>
                <th colspan="37">Кількість годин</th>
                <th rowspan="4"></th>
            </tr>
            <tr>
                <th colspan="4" class="general">за навчальним планом</th>
                <th colspan="15" class="fall">Осінній семестр</th>
                <th colspan="15" class="spring">Весняний семестр</th>
                <th colspan="3">за рік</th>
            </tr>
            <tr>
                <th rowspan="2" class="general">Всього</th>
                <th colspan="2" class="general">з них</th>
                <th rowspan="2" class="general">Кількість кредитів ECTS</th>
                <th rowspan="2" class="general">Всього</th>
                <th rowspan="2" class="general">Аудиторних</th>
                <th rowspan="2" class="general">СРС</th>

                <th rowspan="2" class="fall">всього</th>
                <th rowspan="2" class="fall">самостійна робота</th>
                <th colspan="4" class="fall">з них аудиторних</th>
                <th colspan="3" class="fall">курсові роботи, проекти</th>
                <th rowspan="2" class="fall">розрах. та контр. роб.</th>
                <th rowspan="2" class="fall">Керівництво практикою, дипломне нормоконтроль, ДКК</th>
                <th rowspan="2" class="fall">Консультації</th>
                <th colspan="2" class="fall">Форми контролю</th>
                <th rowspan="2" class="fall">Всього за осінній семестр</th>

                <th rowspan="2" class="spring">всього</th>
                <th rowspan="2" class="spring">самостійна робота</th>
                <th colspan="4" class="spring">з них аудиторних</th>
                <th colspan="3" class="spring">курсові роботи, проекти</th>
                <th rowspan="2" class="spring">розрах. та контр. роб.</th>
                <th rowspan="2" class="spring">Керівництво практикою, дипломне нормоконтроль, ДКК</th>
                <th rowspan="2" class="spring">Консультації</th>
                <th colspan="2" class="spring">Форми контролю</th>
                <th rowspan="2" class="spring">Всього за весняний семестр</th>

                <th rowspan="2">Всього</th>
                <th rowspan="2">Бюджет</th>
                <th rowspan="2">Контракт</th>
            </tr>
            <tr>
                <th class="general">Бюджет</th>
                <th class="general">Контракт</th>
                <th class="fall">всього</th>
                <th class="fall">лекції</th>
                <th class="fall">лабораторні</th>
                <th class="fall">практичні</th>
                <th class="fall">Проектування</th>
                <th class="fall">Перевірка</th>
                <th class="fall">Захист</th>
                <th class="fall">екзамен, ДПА</th>
                <th class="fall">залік</th>

                <th class="spring">всього</th>
                <th class="spring">лекції</th>
                <th class="spring">лабораторні</th>
                <th class="spring">практичні</th>
                <th class="spring">Проектування</th>
                <th class="spring">Перевірка</th>
                <th class="spring">Захист</th>
                <th class="spring">екзамен, ДПА</th>
                <th class="spring">залік</th>

<?php
$fall = array();
$spring = array();
$fall['total'] = 0;
$spring['total'] = 0;
$fall['selfwork'] = 0;
$spring['selfwork'] = 0;
$fall['classes'] = 0;
$spring['classes'] = 0;
$fall['lectures'] = 0;
$spring['lectures'] = 0;
$fall['labs'] = 0;
$spring['labs'] = 0;
$fall['practs'] = 0;
$spring['practs'] = 0;
$fall['project'] = 0;
$spring['project'] = 0;
$fall['check'] = 0;
$spring['check'] = 0;
$fall['control'] = 0;
$spring['control'] = 0;
$fall['works'] = 0;
$spring['works'] = 0;
$fall['dkk'] = 0;
$spring['dkk'] = 0;
$fall['consult'] = 0;
$spring['consult'] = 0;
$fall['exam'] = 0;
$spring['exam'] = 0;
$fall['test'] = 0;
$spring['test'] = 0;
$fall['pay'] = 0;
$spring['pay'] = 0;

$totals = array();
$totals['total'] = 0;
$totals['budget'] = 0;
$totals['contract'] = 0;
?>

<?php
/** @var Load $data */
foreach ($dataProvider->getData() as $data):
if($data->course==$course){
$springSemester = $data->course * 2;
$fallSemester = $springSemester - 1;
?>
            <tr>
                <td>
                    <?php if ($data->type == Load::TYPE_PROJECT) {
                        echo CHtml::link('редагувати', $this->createUrl('edit', array('id' => $data->id))) . '<br>';
                        echo CHtml::link('видалити', $this->createUrl('delete', array('id' => $data->id)));
                    } else echo CHtml::link('редагувати', $this->createUrl('update', array('id' => $data->id))); ?>
                </td>
                <td><b><?php echo $data->planSubject->subject->title; ?></b></td>
                <td><b><?php echo isset($data->teacher) ? $data->teacher->getFullName() :
                            '<span style="color: red">не призначено</span>'; ?></b></td>
                <td class="general"><?php echo $data->course; ?></td>
                <td><b><?php echo $data->group->title; ?></b></td>
                <td class="general"><?php echo $data->getStudentsCount(); ?></td>
                <td class="general"><?php echo $data->getBudgetStudentsCount(); ?></td>
                <td class="general"><?php echo $data->getContractStudentsCount(); ?></td>
                <td class="general"><?php echo $data->getPlanCredits(); ?></td>
                <td class="general"><?php echo $data->getPlanTotal(); ?></td>
                <td class="general"><?php echo $data->getPlanClasses(); ?></td>
                <td class="general"><?php echo $data->getPlanSelfwork(); ?></td>

                <td class="fall">
                    <?php echo $total = $data->getTotal($fallSemester-1);
                    $fall['total'] += intval($total); ?>
                </td>
                <td class="fall">
                    <?php echo $selfwork = $data->getSelfwork($fallSemester-1);
                    $fall['selfwork'] += intval($selfwork); ?>
                </td>
                <td class="fall">
                    <?php echo $classes = $data->getClasses($fallSemester-1);
                    $fall['classes'] += intval($classes); ?>
                </td>
                <td class="fall">
                    <?php echo $lectures = $data->getLectures($fallSemester-1);
                    $fall['lectures'] += intval($lectures); ?>
                </td>
                <td class="fall">
                    <?php echo $labs = $data->getLabs($fallSemester-1);
                    $fall['labs'] += intval($labs); ?>
                </td>
                <td class="fall">
                    <?php echo $practs = $data->getPracts($fallSemester-1);
                    $fall['practs'] += intval($practs); ?>
                </td>
                <td class="fall">
                    <?php echo $project = $data->getProject($fallSemester-1);
                    $fall['project'] = intval($project); ?>
                </td>
                <td class="fall">
                    <?php echo $check = $data->getCheck($fallSemester-1);
                    $fall['check'] = intval($check); ?>
                </td>
                <td class="fall">
                    <?php echo $control = $data->getControl($fallSemester-1);
                    $fall['control'] = intval($control); ?>
                </td>
                <td class="fall">
                    <?php echo $works = $data->getControlWorks($fallSemester-1);
                    $fall['works'] += intval($works); ?>
                </td>
                <td class="fall">
                    <?php echo $dkk = $data->getDkk($fallSemester-1);
                    $fall['dkk'] += intval($dkk); ?>
                </td>
                <td class="fall">
                    <?php echo $consult = $data->getConsultation($fallSemester-1);
                    $fall['consult'] += intval($consult); ?>
                </td>
                <td class="fall">
                    <?php echo $exam = $data->getExam($fallSemester-1);
                    $fall['exam'] += intval($exam); ?>
                </td>
                <td class="fall">
                    <?php echo $test = $data->getTest($fallSemester-1);
                    $fall['test'] += intval($test); ?>
                </td>
                <td class="fall">
                    <b><?php echo $pay_fall = $data->getPay($fallSemester-1);
                        $fall['pay'] += intval($pay_fall); ?></b>
                </td>

                <td class="spring">
                    <?php echo $total = $data->getTotal($springSemester-1);
                    $spring['total'] += intval($total); ?>
                </td>
                <td class="spring">
                    <?php echo $selfwork = $data->getSelfWork($springSemester-1);
                    $spring['selfwork'] += intval($selfwork); ?>
                </td>
                <td class="spring">
                    <?php echo $classes = $data->getClasses($springSemester-1);
                    $spring['classes'] += intval($classes); ?>
                </td>
                <td class="spring">
                    <?php echo $lectures = $data->getLectures($springSemester-1);
                    $spring['lectures'] += intval($lectures); ?>
                </td>
                <td class="spring">
                    <?php echo $labs = $data->getLabs($springSemester-1);
                    $spring['labs'] += intval($labs); ?>
                </td>
                <td class="spring">
                    <?php echo $practs = $data->getPracts($springSemester-1);
                    $spring['practs'] += intval($practs); ?>
                </td>
                <td class="spring">
                    <?php echo $project = $data->getProject($springSemester-1);
                    $spring['project'] += intval($project); ?>
                </td>
                <td class="spring">
                    <?php echo $check = $data->getCheck($springSemester-1);
                    $spring['check'] += intval($check); ?>
                </td>
                <td class="spring">
                    <?php echo $control = $data->getControl($springSemester-1);
                    $spring['control'] += intval($control); ?>
                </td>
                <td class="spring">
                    <?php echo $works = $data->getControlWorks($springSemester-1);
                    $spring['works'] += intval($works);?>
                </td>
                <td class="spring">
                    <?php echo $dkk = $data->getDkk($springSemester-1);
                    $spring['dkk'] += intval($dkk); ?>
                </td>
                <td class="spring">
                    <?php echo $consult = $data->getConsultation($springSemester-1);
                    $spring['consult'] += intval($consult);
                    ?>
                </td>
                <td class="spring">
                    <?php echo $exam = $data->getExam($springSemester-1);
                    $spring['exam'] += $exam; ?>
                </td>
                <td class="spring">
                    <?php echo $test = $data->getTest($springSemester-1);
                    $spring['test'] += $data->getTest($springSemester-1); ?>
                </td>
                <td class="spring">
                    <b><?php echo $pay_spring = $data->getPay($springSemester-1);
                        $spring['pay'] += $pay_spring; ?></b>
                </td>

                <td>
                    <?php echo $all = $pay_fall + $pay_spring;
                    $totals['total'] += $all; ?>
                </td>
                <td>
                    <?php echo $budget = round($all * $data->getBudgetPercent() / 100);
                    $totals['budget'] += $budget; ?>
                </td>
                <td>
                    <?php echo $contract = round($all * $data->getContractPercent() / 100);
                    $totals['contract'] += $contract; ?>
                </td>
                <td>
                    <?php if ($data->type == Load::TYPE_PROJECT)
                        echo CHtml::link('видалити', $this->createUrl('delete', array('id' => $data->id)));
                    else echo CHtml::link('редагувати', $this->createUrl('update', array('id' => $data->id))); ?>
                </td>
            </tr>
            <?php } endforeach; ?>
            <!-- Підсумки -->
            <tr>
                <td colspan="4"><b>Всього</b></td>
                <td class="general" colspan="8"></td>
                <td class="fall"><?php echo $fall['total']; ?></td>
                <td class="fall"><?php echo $fall['selfwork']; ?></td>
                <td class="fall"><?php echo $fall['classes']; ?></td>
                <td class="fall"><?php echo $fall['lectures']; ?></td>
                <td class="fall"><?php echo $fall['labs']; ?></td>
                <td class="fall"><?php echo $fall['practs']; ?></td>
                <td class="fall"><?php echo $fall['project']; ?></td>
                <td class="fall"><?php echo $fall['check']; ?></td>
                <td class="fall"><?php echo $fall['control']; ?></td>
                <td class="fall"><?php echo $fall['works']; ?></td>
                <td class="fall"><?php echo $fall['dkk']; ?></td>
                <td class="fall"><?php echo $fall['consult']; ?></td>
                <td class="fall"><?php echo $fall['exam']; ?></td>
                <td class="fall"><?php echo $fall['test']; ?></td>
                <td class="fall"><?php echo $fall['pay']; ?></td>

                <td class="spring"><?php echo $spring['total']; ?></td>
                <td class="spring"><?php echo $spring['selfwork']; ?></td>
                <td class="spring"><?php echo $spring['classes']; ?></td>
                <td class="spring"><?php echo $spring['lectures']; ?></td>
                <td class="spring"><?php echo $spring['labs']; ?></td>
                <td class="spring"><?php echo $spring['practs']; ?></td>
                <td class="spring"><?php echo $spring['project']; ?></td>
                <td class="spring"><?php echo $spring['check']; ?></td>
                <td class="spring"><?php echo $spring['control']; ?></td>
                <td class="spring"><?php echo $spring['works']; ?></td>
                <td class="spring"><?php echo $spring['dkk']; ?></td>
                <td class="spring"><?php echo $spring['consult']; ?></td>
                <td class="spring"><?php echo $spring['exam']; ?></td>
                <td class="spring"><?php echo $spring['test']; ?></td>
                <td class="spring"><?php echo $spring['pay']; ?></td>

                <td><?php echo $totals['total']; ?></td>
                <td><?php echo $totals['budget']; ?></td>
                <td><?php echo $totals['contract']; ?></td>
                <td></td>
            </tr>
            <!-- Підсумки кінець -->
        </table>
    </div>