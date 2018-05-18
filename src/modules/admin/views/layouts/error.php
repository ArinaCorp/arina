<?php
use nullref\core\widgets\WidgetContainer;

/* @var $this \yii\web\View */
/* @var $content string */

?>

<?php $this->beginContent('@nullref/admin/views/layouts/base.php') ?>
    <div id="wrapper">

        <div class="row">
            <div class="col-md-10 col-md-push-1">
                <?= $content ?>
            </div>
        </div>

    </div>
    <!-- /#wrapper -->
<?= WidgetContainer::widget(['widgets' => Yii::$app->getModule('admin')->globalWidgets]) ?>

<?php $this->endContent('@nullref/admin/views/layouts/base.php') ?>