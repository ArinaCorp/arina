<?php
/**
 * @var WorkController $this
 * @var integer $course
 * @var WorkPlan $model
 */
switch ($course) {
    case 1:
        $fall = 0;
        $spring = 1;
        break;
    case 2:
        $fall = 2;
        $spring = 3;
        break;
    case 3:
        $fall = 4;
        $spring = 5;
        break;
    case 4:
        $fall = 6;
        $spring = 7;
        break;
    default:
        $fall = 0;
        $spring = 1;
}
?>
<table class="table table-bordered">
    <tr>
        <th rowspan="2"></th>
        <th rowspan="2" style="vertical-align: top">Предмет</th>
        <th colspan="8">Осінній семестр: <?php echo $model->semesters[$fall]; ?> тижнів</th>
        <th colspan="8">Веснянний семестр: <?php echo $model->semesters[$spring]; ?> тижнів</th>
    </tr>
    <tr>
        <th>Всього</th>
        <th>Аудиторних</th>
        <th>Лекції</th>
        <th>Практичні</th>
        <th>Лабораторні</th>
        <th>Самостійна робота</th>
        <th>Курсові роботи, проекти</th>
        <th>Кіл. год в тиж.</th>

        <th>Всього</th>
        <th>Аудиторних</th>
        <th>Лекції</th>
        <th>Практичні</th>
        <th>Лабораторні</th>
        <th>Самостійна робота</th>
        <th>Курсові роботи, проекти</th>
        <th>Кількість год в тиждень</th>
    </tr>
    <?php $fallHours = array(
        'total' => 0,
        'classes' => 0,
        'lectures' => 0,
        'labs' => 0,
        'practs' => 0,
        'selfwork' => 0,
        'weeks' => 0,
        'project' => 0,
    ); ?>
    <?php $springHours = array(
        'total' => 0,
        'classes' => 0,
        'lectures' => 0,
        'labs' => 0,
        'practs' => 0,
        'selfwork' => 0,
        'weeks' => 0,
        'project' => 0,
    ); ?>
    <?php foreach ($model->subjects as $subject): ?>
        <?php if ($subject->presentIn($course)): ?>
            <tr>
                <td><?php echo CHtml::link(
                        'редагувати',
                        $this->createUrl('editSubject', array('id' => $subject->id))
                    ); ?>
                    <?php echo CHtml::link(
                        'видалити',
                        $this->createUrl('deleteSubject', array('id' => $subject->id))
                    ) ?></td>
                <td><?php echo isset($subject->subject) ? $subject->subject->title : $subject->subject_id; ?>:
                    <b>(<?php echo array_sum(isset($subject->subject) ? $subject->total : array()); ?> годин)</b>
                </td>

                <td><?php echo $subject->total[$fall];
                    $fallHours['total'] += $subject->total[$fall]; ?></td>
                <td><?php echo $subject->getClasses($fall);
                    $fallHours['classes'] += $subject->getClasses($fall); ?></td>
                <td><?php echo $subject->lectures[$fall];
                    $fallHours['lectures'] += $subject->lectures[$fall]; ?></td>
                <td><?php echo $subject->practs[$fall];
                    $fallHours['practs'] += $subject->practs[$fall]; ?></td>
                <td><?php echo $subject->labs[$fall];
                    $fallHours['labs'] += $subject->labs[$fall]; ?></td>
                <td><?php echo $subject->getSelfWork($fall);
                    $fallHours['selfwork'] += $subject->getSelfwork($fall); ?></td>
                <td><?php echo ($subject->control[$fall][4] || $subject->control[$fall][5]) ? $subject->project_hours : '';
                    $fallHours['project'] += $subject->project_hours; ?></td>
                <td><?php echo $subject->weeks[$fall];
                    $fallHours['weeks'] += $subject->weeks[$fall]; ?></td>

                <td><?php echo $subject->total[$spring];
                    $springHours['total'] += $subject->total[$spring]; ?></td>
                <td><?php echo $subject->getClasses($spring);
                    $springHours['classes'] += $subject->getClasses($spring); ?></td>
                <td><?php echo $subject->lectures[$spring];
                    $springHours['lectures'] += $subject->lectures[$spring]; ?></td>
                <td><?php echo $subject->practs[$spring];
                    $springHours['practs'] += $subject->practs[$spring]; ?></td>
                <td><?php echo $subject->labs[$spring];
                    $springHours['labs'] += $subject->labs[$spring]; ?></td>
                <td><?php echo $subject->getSelfWork($spring);
                    $springHours['selfwork'] += $subject->getSelfwork($spring); ?></td>
                <td><?php echo ($subject->control[$spring][4] || $subject->control[$spring][5]) ? $subject->project_hours : '';
                    $springHours['project'] += $subject->project_hours; ?></td>
                <td><?php echo $subject->weeks[$spring];
                    $springHours['weeks'] += $subject->weeks[$spring]; ?></td>

                <td><?php echo CHtml::link(
                        'редагувати',
                        $this->createUrl('editSubject', array('id' => $subject->id))
                    ); ?>
                    <?php echo CHtml::link(
                        'видалити',
                        $this->createUrl('deleteSubject', array('id' => $subject->id))
                    ) ?></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
    <tr>
        <td colspan="2"><b>Всього</b></td>

        <td><b><?php echo $fallHours['total']; ?></b></td>
        <td><b><?php echo $fallHours['classes']; ?></b></td>
        <td><b><?php echo $fallHours['lectures']; ?></b></td>
        <td><b><?php echo $fallHours['practs']; ?></b></td>
        <td><b><?php echo $fallHours['labs']; ?></b></td>
        <td><b><?php echo $fallHours['selfwork']; ?></b></td>
        <td><b><?php echo $fallHours['project']; ?></b></td>
        <td><b><?php echo $fallHours['weeks']; ?></b></td>

        <td><b><?php echo $springHours['total']; ?></b></td>
        <td><b><?php echo $springHours['classes']; ?></b></td>
        <td><b><?php echo $springHours['lectures']; ?></b></td>
        <td><b><?php echo $springHours['practs']; ?></b></td>
        <td><b><?php echo $springHours['labs']; ?></b></td>
        <td><b><?php echo $springHours['selfwork']; ?></b></td>
        <td><b><?php echo $springHours['project']; ?></b></td>
        <td><b><?php echo $springHours['weeks']; ?></b></td>

        <td></td>
    </tr>
</table>