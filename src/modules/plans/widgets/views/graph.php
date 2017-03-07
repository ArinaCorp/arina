<?php

use yii\helpers\Url;

use yii\helpers\Html;
use app\modules\plans\widgets\Graph;

/**
 * @var boolean $readOnly
 * @var Graph $this
 * @var string $graphProcessLink
 * @var array $list
 * @var array $rows
 * @var array $map
 */
?>
    <style>
        div.result {
            margin-top: 15px;
        }

        div.result img.load {
            display: block;
            width: 32px;
            margin: auto;
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
                <th colspan="<?php echo $item; ?>"><?php echo Yii::t('base', $key); ?></th>
            <?php endforeach; ?>
        </tr>
        <tr class="numbers">
            <?php for ($i = 0; $i < $amount; $i++): ?>
                <th>
                    <?php echo $i + 1; ?>
                </th>
            <?php endfor; ?>
        </tr>
        </thead>
        <tbody>
        <?php
        $j = 0;
        foreach ($rows as $key => $name): ?>
            <tr class="line">
                <td><span><?= $key; ?></span>
                    <input
                        name="<?= "groups[$name][$j]"; ?>" data-state="<?= $key; ?>" type="hidden"/>
                </td>
                <?php for ($i = 0; $i < $amount; $i++): ?>
                    <td>
                        <input
                            name="<?= "graph[$j][$i]"; ?>"
                            type="button" class="btn"
                            value="<?= Yii::t('plan', $map[$j][$i]); ?>"
                            data-state="<?= $map[$j][$i]; ?>"/>
                    </td>
                <?php endfor; ?>
            </tr>
            <?php
            $j++;
        endforeach; ?>
        </tbody>
    </table>
<?php if (!$readOnly): ?>
    <script>
        var t = "<?= Yii::t('plans','T'); ?>";
        var s = "<?= Yii::t('plans','S'); ?>";
        var p = "<?= Yii::t('plans','P'); ?>";
        var h = "<?= Yii::t('plans','H'); ?>";
        var dp = "<?= Yii::t('plans','DP'); ?>";
        var da = "<?= Yii::t('plans','DA'); ?>";
        var empty = " ";
        $(function () {
            var loader = $('img.load').hide();
            $('tr.line').find('input').click(function () {
                $.get("<?= Url::to("/plans/study-plan/reset-graph");?>").done(function () {
                    $("div.result").empty();
                });
                var obj = $(this);
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
            });
            $('#generate').click(function (e) {
                $("div.result").fadeOut();
                loader.show();
                var done = function (html) {
                    loader.fadeOut();
                    $("div.result").empty().append(html).fadeIn();
                };
                var myInputs = $('#graph').find('input').clone();
                myInputs.each(function (i, val) {
                    var v = $(val);
                    if (!v) {
                        v = $(val).defaultValue;
                    }
                    v.attr('type', 'text');
                    v.val(v.attr('data-state'));
                });
                var data = $('<form>').append(myInputs).serialize();
                var posting = $.post(url, data).done(done);
                console.log(data);
                e.preventDefault(e);
            });
        });
    </script>
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

    <?= Html::button(Yii::t('app', 'Generate'), [ 'class' => 'btn btn-primary', 'id' => 'generate' ]); ?>

    <div class="result">
    </div>
<?php endif; ?>