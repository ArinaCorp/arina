<?php
/**
 * @var array $data
 */
?>
<table class="table table-striped table-condensed table-bordered table-hover">
    <thead>
    <tr>
        <td><?= Yii::t('app', 'Course'); ?></td>
        <td><?= Yii::t('app', 'Autumn'); ?></td>
        <td><?= Yii::t('app', 'Spring'); ?></td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $i => $v): ?>
        <tr>
            <td><?= $i; ?></td>
            <?php foreach ($v as $j): ?>
                <td><?= $j; ?></td>
            <?php endforeach;?>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
