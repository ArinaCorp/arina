<?php

use app\modules\plans\models\StudentPlan;
use app\modules\plans\models\WorkPlan;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $model StudentPlan
 * @var $course integer
 * @var $semester integer|string
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
$semester = ($semester == 2 ? 'spring' : 'fall');
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
        <?php if ($subject->presentIn($course) && strpos($subject->subject->code, 'ПВС') === false): ?>
            <tr>
                <td><?= isset($subject->subject) ? $subject->subject->title : $subject->subject_id; ?></td>

                <td><?= $subject->total[${$semester}]; ?></td>
                <td><?= $subject->getClasses(${$semester}); ?></td>
                <td><?= $subject->lectures[${$semester}]; ?></td>
                <td><?= $subject->practices[${$semester}]; ?></td>
                <td><?= $subject->lab_works[${$semester}]; ?></td>
                <td><?= $subject->getSelfWork(${$semester}); ?></td>
                <td><?= $subject->project_hours; ?></td>
                <td><?= $subject->weeks[${$semester}]; ?></td>

            </tr>
        <?php endif; ?>
    <?php endforeach; ?>

</table>

<table class="table table-bordered">
    <tr>
        <th rowspan="2" style="vertical-align: top"><?= Yii::t('app', 'Selected subject'); ?></th>
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
    <!--    Selected Subject blocks   -->

    <?php foreach ($model->subjectBlock->workSubjects as $workSubject): ?>
        <?php if ($workSubject->presentIn($course)): ?>
            <tr>
                <td><?= isset($workSubject->subject) ? $workSubject->subject->title : $workSubject->subject_id; ?></td>

                <td><?= $workSubject->total[${$semester}]; ?></td>
                <td><?= $workSubject->getClasses(${$semester}); ?></td>
                <td><?= $workSubject->lectures[${$semester}]; ?></td>
                <td><?= $workSubject->practices[${$semester}]; ?></td>
                <td><?= $workSubject->lab_works[${$semester}]; ?></td>
                <td><?= $workSubject->getSelfWork(${$semester}); ?></td>
                <td><?= $workSubject->project_hours; ?></td>
                <td><?= $workSubject->weeks[${$semester}]; ?></td>

            </tr>
        <?php endif; ?>
    <?php endforeach; ?>

</table>
