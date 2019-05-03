<?php

use app\modules\plans\models\WorkPlan;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $model WorkPlan
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
        <th rowspan="2" style="vertical-align: top"><?= Yii::t('plans', 'Subject'); ?></th>
        <th colspan="8"><?= Yii::t('plans', 'Autumn semester').' '.
            ($model->semesters[$fall] ?? '') . ' ' . Yii::t('plans', 'OfWeeks'); ?></th>
        <th colspan="8"><?= Yii::t('plans', 'Spring semester').' '.
            ($model->semesters[$spring] ?? '') . ' ' . Yii::t('plans', 'OfWeeks'); ?></th>
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
    <?php foreach ($model->workSubjects as $subject): ?>
        <?php if ($subject->presentIn($course)): ?>
            <tr>
                <td><?= Html::a(
                        Yii::t('app', 'Update'),
                        Url::toRoute(['work-plan/update-subject', 'id' => $subject->id])
                    ); ?>
                    <?= Html::a(
                        Yii::t('app', 'Delete'),
                        Url::toRoute(['work-plan/delete-subject', 'id' => $subject->id])
                    ); ?>
                <td><?= isset($subject->subject) ? $subject->subject->title : $subject->subject_id; ?>:
                    <b>(<?= array_sum(isset($subject->subject) ? $subject->total : []); ?> годин)</b>
                </td>

                <td><?= $subject->total[$fall];
                    $fallHours['total'] += intval($subject->total[$fall]); ?></td>
                <td><?= $subject->getClasses($fall);
                    $fallHours['classes'] += $subject->getClasses($fall); ?></td>
                <td><?= $subject->lectures[$fall];
                    $fallHours['lectures'] += intval($subject->lectures[$fall]); ?></td>
                <td><?= $subject->practices[$fall];
                    $fallHours['practices'] += intval($subject->practices[$fall]); ?></td>
                <td><?= $subject->lab_works[$fall];
                    $fallHours['lab_works'] += intval($subject->lab_works[$fall]); ?></td>
                <td><?= $subject->getSelfWork($fall);
                    $fallHours['self_work'] += intval($subject->getSelfwork($fall)); ?></td>
                <td><?= ($subject->control[$fall][4] || $subject->control[$fall][5]) ? $subject->project_hours : '';
                    $fallHours['project'] += intval($subject->project_hours); ?></td>
                <td><?= $subject->weeks[$fall];
                    $fallHours['weeks'] += intval($subject->weeks[$fall]); ?></td>

                <td><?= $subject->total[$spring];
                    $springHours['total'] += intval($subject->total[$spring]); ?></td>
                <td><?= $subject->getClasses($spring);
                    $springHours['classes'] += $subject->getClasses($spring); ?></td>
                <td><?= $subject->lectures[$spring];
                    $springHours['lectures'] += intval($subject->lectures[$spring]); ?></td>
                <td><?= $subject->practices[$spring];
                    $springHours['practices'] += intval($subject->practices[$spring]); ?></td>
                <td><?= $subject->lab_works[$spring];
                    $springHours['lab_works'] += intval($subject->lab_works[$spring]); ?></td>
                <td><?= $subject->getSelfWork($spring);
                    $springHours['self_work'] += intval($subject->getSelfwork($spring)); ?></td>
                <td><?= ($subject->control[$spring][4] || $subject->control[$spring][5]) ? $subject->project_hours : '';
                    $springHours['project'] += intval($subject->project_hours); ?></td>
                <td><?= $subject->weeks[$spring];
                    $springHours['weeks'] += intval($subject->weeks[$spring]); ?></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
    <tr>
        <td colspan="2"><b><?= Yii::t('plans', 'Total'); ?></b></td>

        <td><b><?= $fallHours['total']; ?>      </b></td>
        <td><b><?= $fallHours['classes']; ?>    </b></td>
        <td><b><?= $fallHours['lectures']; ?>   </b></td>
        <td><b><?= $fallHours['practices']; ?>  </b></td>
        <td><b><?= $fallHours['lab_works']; ?>  </b></td>
        <td><b><?= $fallHours['self_work']; ?>  </b></td>
        <td><b><?= $fallHours['project']; ?>    </b></td>
        <td><b><?= $fallHours['weeks']; ?>      </b></td>

        <td><b><?= $springHours['total']; ?>    </b></td>
        <td><b><?= $springHours['classes']; ?>  </b></td>
        <td><b><?= $springHours['lectures']; ?> </b></td>
        <td><b><?= $springHours['practices']; ?></b></td>
        <td><b><?= $springHours['lab_works']; ?></b></td>
        <td><b><?= $springHours['self_work']; ?></b></td>
        <td><b><?= $springHours['project']; ?>  </b></td>
        <td><b><?= $springHours['weeks']; ?>    </b></td>

        <td></td>
    </tr>
</table>