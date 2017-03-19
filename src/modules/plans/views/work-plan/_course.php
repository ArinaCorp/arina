<?php

use yii\web\View;

use app\modules\plans\models\WorkPlan;

/**
 * @var View $this
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
    <?= 'kekee'?>
</table>