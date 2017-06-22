<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\journal\models\record\JournalRecord;
use app\modules\journal\models\record\JournalStudent;

/* @var $this yii\web\View */
/* @var $model \app\modules\load\models\Load */
/* @var $students \app\modules\students\models\Student[] */
/* @var $list JournalRecord[] */
/* @var $map [][]; */

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
            <td rowspan="2"><?= Yii::t('terms', 'N p/p'); ?></td>
            <td class="name" rowspan="2"><?= Yii::t('terms', 'Surname and initials'); ?></td>
            <td colspan="<?= count($list) + 1; ?> " id="center"><?= Yii::t('terms', 'Day, month') ?></td>
        </tr>
        <tr>
            <?php
            $krecords = 0;
            foreach ($list as $key) {
                $krecords++; ?>
                <td class="oc record" align="center"><?php echo $key->label ?></td>
                <?
            }
            //            if ($t) {
            echo '<td class="record">' . Html::a(Yii::t('app', 'create'), ['journal-record/create-first', 'load_id' => $model->id]) . '</td>';
            //            }
            ?>
        </tr>
        <?php
        $i = 0;
        foreach ($students as $student) {
            ?>
            <tr>
                <td>
                    <?php echo $i + 1; ?>
                </td>
                <td class="name">
                    <?php echo $student->getLink() ?>
                </td>
                <?php foreach ($list as $item) { ?>
                    <td>
                        <?= $map[$student->id][$item->id] ?>
                    </td>

                    <?

                }
                if (true) echo '<td></td>';
                ?>
            </tr>
            <?

            $i++;
        }
        ?>
    </table>


</div>