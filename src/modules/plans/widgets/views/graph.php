<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var boolean $readOnly
 * @var View $this
 * @var string $graphProcessLink
 * @var array $list
 * @var array $rows
 * @var array $map
 * @var boolean $studyPlan
 */

?>
    <style>
        div.result {
            margin-top: 15px;
        }

        table.graph * {
            text-align: center;
        }

        table.graph tr.numbers th,
        table.graph td {
            padding-left: 0;
            padding-right: 0;
            font-weight: normal;
        }

        table.graph tr.line > td {
            padding: 0;
        }

        table.graph tr.line td > span {
            padding: 0 5px;
        }

        table.graph tr.line > td > input {
            padding: 1px 1px;
            border-radius: 0;
            width: 100%;
            border: none;
            min-width: 16px;
            display: block;
        }
    </style>
    <table id="graph" class="graph items table table-striped table-condensed table-bordered table-hover">
        <thead>
        <tr>
            <th rowspan="2"></th>
            <?php
            $amount = 0;
            foreach ($list as $key => $item):
                $amount += $item;
                ?>
                <th colspan="<?php echo $item; ?>"><?php echo Yii::t('app', $key); ?></th>
            <?php endforeach; ?>
        </tr>
        <tr class="numbers">
            <?php for ($i = 0; $i < $amount; $i++): ?>
                <th>
                    <?= $i + 1; ?>
                </th>
            <?php endfor; ?>
        </tr>
        </thead>
        <tbody>
        <?php
        $j = 0;
        foreach ($rows as $key => $name): ?>
            <tr class="line" data-group="<?= $key ?>">
                <td>
                    <?php if ($studyPlan): ?>
                        <span><?= $key; ?></span>
                    <?php else: ?>
                        <span><?= $name ?> - <?= $key; ?></span>
                    <?php endif ?>
                    <input
                        name="<?= "groups[$name][$j]"; ?>" data-state="<?= $name ?> - <?= $key; ?>" type="hidden"/>
                </td>
                <?php for ($i = 0; $i < $amount; $i++): ?>
                    <td>
                        <input
                            name="<?= "graph[$j][$i]"; ?>"
                            type="button" class="btn"
                            value="<?= Yii::t('plans', $map[$j][$i]); ?>"
                            data-state="<?= $map[$j][$i]; ?>"
                            data-week-number="<?= $i+1?>"
                        />
                    </td>
                <?php endfor; ?>
            </tr>
            <?php
            $j++;
        endforeach; ?>
        </tbody>
    </table>
<?php if (!$readOnly):
    $resetGraphUrl = Url::to("/plans/study-plan/reset-graph");
    $graphProcessUrl = Url::to($graphProcessLink);

    /** Generate js translations for types */
    $js = implode(PHP_EOL, array_map(function ($item) {
        return 'var ' . $item . ' = "' . Yii::t('plans', strtoupper($item)) . '";';
    }, ['t', 's', 'p', 'h', 'dp', 'da']));


    $js .= <<<JS
    
var empty = " ";
var loader = jQuery('img.load').hide();
jQuery('tr.line').find('input').click(function () {
    $.get("$resetGraphUrl").done(function () {
        jQuery("div.result").empty();
    });
    var obj = jQuery(this);
    
    switch (obj.attr('data-state')) {
        case 'T':
            obj.val(s);
            obj.attr('data-state', 'S');
            break;
        case 'S':
            obj.val(p);
            obj.attr('data-state', 'P');
            break;
        case 'P':
            obj.val(h);
            obj.attr('data-state', 'H');
            break;
        case 'H':
            obj.val(dp);
            obj.attr('data-state', 'DP');
            break;
        case 'DP':
            obj.val(da);
            obj.attr('data-state', 'DA');
            break;
        case 'DA':
            obj.val(empty);
            obj.attr('data-state', ' ');
            break;
        case ' ':
            obj.val(t);
            obj.attr('data-state', 'T');
            break;
    }
    console.log('changed to ' + obj.attr('data-state'));
});
jQuery('#generate').click(function (e) {

    jQuery("div.result").fadeOut();
    loader.show();
    console.log('generated');
    var done = function (html) {
        loader.fadeOut();
        jQuery("div.result").empty().append(html).fadeIn();
    };
    var myInputs = jQuery('#graph').find('input').clone();
    myInputs.each(function (i, val) {
        var v = jQuery(val);
        if (!v) {
            v = jQuery(val).defaultValue;
        }
        v.attr('type', 'text');
        v.val(v.attr('data-state'));
    });
    var data = jQuery('<form>').append(myInputs).serialize();
    var url = "$graphProcessUrl";
    var posting = $.post(url, data).done(done);

    console.log(data);
});
JS;

    $this->registerJs($js);
    ?>
    <span>
    <?= Yii::t('plans', 'Guide'); ?>
</span>
    <ul>
        <li><?= Yii::t('plans', 'T - theoretical training'); ?> </li>
        <li><?= Yii::t('plans', 'S - examination session'); ?>  </li>
        <li><?= Yii::t('plans', 'P - practice'); ?>             </li>
        <li><?= Yii::t('plans', 'H - vacation (holidays)'); ?>  </li>
        <li><?= Yii::t('plans', 'DP - diploma design'); ?>      </li>
        <li><?= Yii::t('plans', 'DA - state certification'); ?> </li>
    </ul>

    <?= Html::button(Yii::t('app', 'Generate'), ['class' => 'btn btn-primary', 'id' => 'generate']); ?>

    <div class="result">
    </div>
<?php endif; ?>