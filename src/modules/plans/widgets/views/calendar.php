<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2019 NRE
 *
 * @var $this \yii\web\View
 *
 * @var $year \app\modules\directories\models\study_year\StudyYear
 * @var $years array
 * @var $week integer
 * @var $weeks array
 */


$setYearUrl = \yii\helpers\Url::to(['/plans/calendar/set-current-year']);
$setWeekUrl = \yii\helpers\Url::to(['/plans/calendar/set-current-week']);
$this->registerJs(<<<JS
jQuery('body').on('click', '.calendar-widget', function (e) {
    e.preventDefault(e);
    return false;
});

function notify(msg) {
    $.notify({
        "icon": "glyphicon glyphicon-info-sign",
        "title": '',
        "message": msg
    }, {
        "type": "info",
        "allow_dismiss": true,
        "newest_on_top": true,
        "placement": {"from": "top", "align": "right"},
        "delay": "500"
    });
}

jQuery('.calendar-widget [name="year"]').on('change', function () {
    var select = jQuery(this);
    var id = select.val();
    jQuery.ajax({
        url: '$setYearUrl',
        method: 'post',
        data: {
            id: id
        },
        success: function (data) {
            if (data.success) {
                notify(data.message);
                jQuery('.calendar-widget-year-title').text(select.find('[value="'+id+'"]').text());
                jQuery('body').trigger('calendar.change');
            }
        }
    });
});

jQuery('.calendar-widget [name="week"]').on('change', function () {
    var week = jQuery(this).val();
    jQuery.ajax({
        url: '$setWeekUrl',
        method: 'post',
        data: {
            week: week
        },
        success: function (data) {
            if (data.success) {
                notify(data.message);
                jQuery('.calendar-widget-week-title').text(week);
                jQuery('body').trigger('calendar.change');
            }
        }
    });
});
JS
);
?>

<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-calendar fa-fw"></i>
        <span class="calendar-widget-year-title"><?= $year->getTitle() ?></span>
        <?= Yii::t('app', 'Week') ?>:
        <span class="calendar-widget-week-title"><?= $week ?></span>
        <i class="fa fa-caret-down"></i>
    </a>
    <div class="dropdown-menu dropdown-messages calendar-widget">

        <div class="form-group">
            <label for="year"><?= Yii::t('app', 'Study year') ?></label>
            <?= \yii\helpers\Html::dropDownList('year', $year->id, $years, ['class' => 'form-control']) ?>
        </div>

        <div class="form-group">
            <label for="year"><?= Yii::t('app', 'Week') ?></label>
            <?= \yii\helpers\Html::dropDownList('week', $week, $weeks, ['class' => 'form-control']) ?>
        </div>


    </div>
</li>
