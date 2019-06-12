<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2019 NRE
 *
 * @var $workPlan \app\modules\plans\models\WorkPlan
 * @var $this \yii\web\View
 */

$this->title = $workPlan->getTitle();

use app\modules\plans\widgets\Graph;
use yii\helpers\Html;

$url = \yii\helpers\Url::to(['/plans/calendar/info', 'work_plan_id' => $workPlan->id]);

$this->registerJs(<<<JS
jQuery('[data-week-number="$week"]').css('background','#afd9ee');

jQuery('[data-course-number="$course"]').css('background','#afd9ee');

jQuery('body').on('calendar.change', function(){
    location.reload();
});

jQuery('body').on('calendar.change', function(){
    location.reload();
});

jQuery('[data-course-number]').on('click', function(){
    var course =  jQuery(this).data('courseNumber');
    location = '$url'.addUrlParam('course', course);
});
JS
);


?>
<style>
    [data-course-number] {
        cursor: pointer;
    }
</style>
<div class="calendar-info">

    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">
                <?= Html::encode($this->title) ?>
            </h3>
        </div>
    </div>
    <p>
        <?= Graph::widget([
            'model' => $workPlan,
            'field' => '',
            'graph' => $workPlan->graph,
            'studyPlan' => false,
            'readOnly' => true,
            'speciality_qualification_id' => $workPlan->speciality_qualification_id,
            'study_year_id' => $workPlan->study_year_id,
        ]); ?>
    </p>
    <p>
        Current course: <?= $course ?>
    </p>
    <p>
        Current semester: <?= $semester ?>
    </p>
    <p>
        Current week: <?= $week ?>
    </p>

</div>