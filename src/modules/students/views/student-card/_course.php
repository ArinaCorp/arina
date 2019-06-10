<?php

use app\modules\plans\models\WorkPlan;
use app\modules\students\models\StudentCard;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $model StudentCard
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
        <th rowspan="4"
            style="vertical-align: top"><?= Yii::t('plans', 'Name of the academic discipline and academic practices'); ?></th>
    </tr>
    <tr>
        <th rowspan="1" colspan="2"><?= Yii::t('plans', 'Total amount'); ?></th>
        <th rowspan="2" colspan="2"><?= Yii::t('plans', 'Semester control, grade'); ?></th>
        <th rowspan="3"><?= Yii::t('plans', 'Semester control date and certificate number'); ?></th>
    </tr>

    <tr>
        <th rowspan="2"><?= Yii::t('plans', 'Hours'); ?></th>
        <th rowspan="2"><?= Yii::t('plans', 'Of ECTS credits'); ?></th>
    </tr>

    <tr>
        <th><?= Yii::t('plans', 'Grade'); ?></th>
        <th><?= Yii::t('plans', 'By national scale'); ?></th>
    </tr>

    <tr>
        <th colspan="6"><?= Yii::t('plans', 'Autumn semester') ?></th>
    </tr>

    <?php if ($model->getMarks($fall + 1)):
        foreach ($model->getMarks($fall + 1) as $mark): ?>
            <tr>
                <td><?= $mark->workSubject->title; ?></td>
                <!--TODO: Total hours per semester should probably be taken from Load rather than Work Plan-->
                <td><?= $mark->workSubject->total[$fall]; ?></td>
                <td><?= number_format($mark->workSubject->total[$fall] / 30, 2); ?></td>
                <td><?= $mark->valueLiteral; ?></td>
                <td><?= $mark->valueScale; ?></td>
                <td><?= $mark->date; ?></td>
            </tr>
        <?php endforeach;
    endif; ?>

    <tr>
        <th colspan="6"><?= Yii::t('plans', 'Spring semester') ?></th>
    </tr>

    <?php if ($model->getMarks($spring + 1)):
        foreach ($model->getMarks($spring + 1) as $mark): ?>
            <tr>
                <td><?= $mark->workSubject->title; ?></td>
                <!--TODO: Total hours per semester should probably be taken from Load rather than Work Plan-->
                <td><?= $mark->workSubject->total[$spring]; ?></td>
                <td><?= number_format($mark->workSubject->total[$spring] / 30, 2); ?></td>
                <td><?= $mark->valueLiteral; ?></td>
                <td><?= $mark->valueScale; ?></td>
                <td><?= $mark->date; ?></td>
            </tr>
        <?php endforeach;
    endif; ?>

</table>