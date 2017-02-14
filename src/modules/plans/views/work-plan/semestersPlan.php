<?php
/**
 *
 * @var PlanController $this
 * @var array $data
 * @var array $errors
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
        <td>Група</td>
        <td>Осінній</td>
        <td>Весняний</td>
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