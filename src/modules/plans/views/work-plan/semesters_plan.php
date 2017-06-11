<?php
/**
 * @var array errors
 * @var array $data
 */
?>
<?php if ($errors): ?>
    <div class="alert alert-error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
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
        <tr class="<?php echo (isset($errors[$i]))?'error':''; ?>">
            <td><?php echo $i; ?></td>
            <?php foreach ($v as $j): ?>
                <td><?php echo $j; ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>