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
            <td><?php echo $i; ?></td>
            <?php foreach ($v as $j): ?>
                <td><?php echo $j; ?></td>
            <?php endforeach;?>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>