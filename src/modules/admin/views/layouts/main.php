<?php
use nullref\admin\widgets\Flash;
use nullref\core\widgets\WidgetContainer;

/* @var $this \yii\web\View */
/* @var $content string */

?>

<?php $this->beginContent('@nullref/admin/views/layouts/base.php') ?>
    <div id="wrapper">

        <?= $this->render('header') ?>

        <div id="page-wrapper" class="maximized">
            <?= Flash::widget() ?>
            <?= $content ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?= WidgetContainer::widget(['widgets' => Yii::$app->getModule('admin')->globalWidgets]) ?>

<?php $this->endContent('@nullref/admin/views/layouts/base.php') ?>
