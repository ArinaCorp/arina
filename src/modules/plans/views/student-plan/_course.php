<?php

use app\modules\plans\models\StudentPlan;
use app\modules\plans\models\WorkPlan;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $model StudentPlan
 * @var $course integer
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
        // TODO: remove subtraction, it's a getZaglushka lol
        $fall = 4 - 1;
        $spring = 5 - 2;
        break;
    case 4:
        $fall = 6 - 3;
        $spring = 7 - 4;
        break;
    default:
        $fall = 0;
        $spring = 1;
}
?>

<table class="table table-bordered">
    <tr>
        <th rowspan="2" style="vertical-align: top"><?= Yii::t('plans', 'Subject'); ?></th>
    </tr>
    <tr>
        <th><?= Yii::t('plans', 'Total'); ?>                  </th>
        <th><?= Yii::t('plans', 'Classes'); ?>                </th>
        <th><?= Yii::t('plans', 'Lectures'); ?>               </th>
        <th><?= Yii::t('plans', 'Practices'); ?>              </th>
        <th><?= Yii::t('plans', 'Laboratory works'); ?>       </th>
        <th><?= Yii::t('plans', 'Self work'); ?>              </th>
        <th><?= Yii::t('plans', 'Course projects, works'); ?> </th>
        <th><?= Yii::t('plans', 'Hours per week'); ?>         </th>
    </tr>

    <?php $fallHours = [
        'total' => 0,
        'classes' => 0,
        'lectures' => 0,
        'lab_works' => 0,
        'practices' => 0,
        'self_work' => 0,
        'weeks' => 0,
        'project' => 0,
    ]; ?>
    <?php $springHours = [
        'total' => 0,
        'classes' => 0,
        'lectures' => 0,
        'lab_works' => 0,
        'practices' => 0,
        'self_work' => 0,
        'weeks' => 0,
        'project' => 0,
    ]; ?>
    <?php foreach ($model->workPlan->workSubjects as $subject): ?>
        <?php if ($subject->presentIn($course) && strpos($subject->subject->code, 'ПВС')===false): ?>
            <tr>
                <td><?= isset($subject->subject) ? $subject->subject->title : $subject->subject_id; ?>:
                    <b>(<?= array_sum(isset($subject->subject) ? $subject->total : []); ?> годин)</b>
                </td>

                <td><?= $subject->total[$fall] + $subject->total[$spring]; ?></td>
                <td><?= $subject->getClasses($fall) + $subject->getClasses($spring); ?></td>
                <td><?= $subject->lectures[$fall] + $subject->lectures[$spring]; ?></td>
                <td><?= $subject->practices[$fall] + $subject->practices[$spring]; ?></td>
                <td><?= $subject->lab_works[$fall] + $subject->lab_works[$spring]; ?></td>
                <td><?= $subject->getSelfWork($fall) + $subject->getSelfWork($spring); ?></td>
                <td><?= $subject->project_hours; ?></td>
                <td><?= $subject->weeks[$fall] + $subject->weeks[$spring]; ?></td>

            </tr>
        <?php endif; ?>
    <?php endforeach; ?>

    <!--    Selected Subject blocks   -->

    <?php foreach ($model->getWorkSubjectsBlock() as $subject): ?>
        <?php if ($subject->presentIn($course)): ?>
            <tr>
                <td><?= isset($subject->subject) ? $subject->subject->title : $subject->subject_id; ?>:
                    <b>(<?= array_sum(isset($subject->subject) ? $subject->total : []); ?> годин)</b>
                </td>

                <td><?= $subject->total[$fall] + $subject->total[$spring]; ?></td>
                <td><?= $subject->getClasses($fall) + $subject->getClasses($spring); ?></td>
                <td><?= $subject->lectures[$fall] + $subject->lectures[$spring]; ?></td>
                <td><?= $subject->practices[$fall] + $subject->practices[$spring]; ?></td>
                <td><?= $subject->lab_works[$fall] + $subject->lab_works[$spring]; ?></td>
                <td><?= $subject->getSelfWork($fall) + $subject->getSelfWork($spring); ?></td>
                <td><?= $subject->project_hours; ?></td>
                <td><?= $subject->weeks[$fall] + $subject->weeks[$spring]; ?></td>

            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>