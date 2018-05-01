<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var $this  yii\web\View
 */

?>

<?= $this->render('/_alert', [
    'module' => Yii::$app->getModule('rbac'),
]) ?>

<div>
    <?= $content ?>
</div>