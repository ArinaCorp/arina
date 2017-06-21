<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\journal\models\record\JournalRecord;

/* @var $this yii\web\View */
/* @var $model \app\modules\load\models\Load */

$this->title = $model->getLabelInfo();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Journal Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="journal">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'List'), ['/journal/journal-student', 'load_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <table class="journal graph table items table-striped table-condensed table-bordered table-hover">
        <tr>
            <td rowspan="2"><? echo Yii::t('terms', 'N p/p'); ?></td>
            <td class="name" rowspan="2"><? echo Yii::t('terms', 'Surname and initials'); ?></td>
            <td colspan="<? echo count($list) + $k; ?> " id="center"><? echo Yii::t('terms', 'Day, month') ?></td>
        </tr>
        <tr>
            <?php
            $krecords = 0;
            foreach (Jou as $key) {
                $krecords++; ?>
                <td class="oc record" align="center"><?php echo $key ?></td>
                <?
            }
            if ($t) {
                echo '<td class="record">' . Html::a(Yii::t('app', 'create'), ['journal-record/create', 'load_id' => $load_id]) . '</td>';
            }
            ?>
        </tr>
        <?
        $i = 0;
        foreach ($rows as $row) {
            ?>
            <tr>
                <td>
                    <? echo $i + 1; ?>
                </td>
                <td class="name">
                    <? echo $row ?>
                </td>
                <? for ($j = 0; $j < $krecords; $j++) {
                    if ($map[$i][$j] == 'Відраховано') {
                        echo '<td class="oc" id="back" align="center">';
                    } else {
                        ?>
                        <td class="oc" align="center">

                        <? echo $map[$i][$j] ?>
                    <?
                    } ?>
                    </td>

                    <?

                }
                if ($t) echo '<td></td>';
                ?>
            </tr>
            <?

            $i++;
        }
        ?>
    </table>


</div>