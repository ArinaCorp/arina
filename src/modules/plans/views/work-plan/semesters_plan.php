<?php
/**
 * @var array $errors
 * @var array $data
 */
?>
<?php if ($errors): ?>
    <div class="alert alert-error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error; ?></li>
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
        <tr class="<?= (isset($errors[$i]))?'error':''; ?>">
            <td><?= $i; ?></td>
            <?php foreach ($v as $j): ?>
                <td><?= $j; ?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>