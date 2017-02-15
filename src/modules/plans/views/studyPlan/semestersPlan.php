<?php
/**
 *
 * @var PlanController $this
 * @var array $data
 */
?>
<table class="table table-striped table-condensed table-bordered table-hover">
    <thead>
    <tr>
        <td>Курс</td>
        <td>Осінній</td>
        <td>Весняний</td>
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