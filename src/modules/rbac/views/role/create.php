<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\web\View;
use dektrium\rbac\models\Role;

/**
 * @var $model Role
 * @var $this View
 */


$this->title = Yii::t('rbac', 'Create role');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginContent('@app/modules/rbac/views/layout.php') ?>

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('rbac', 'List'), ['/rbac/role/index'], ['class' => 'btn btn-success']) ?>
    </p>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

<?php $this->endContent() ?>