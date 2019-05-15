<?php
/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\rbac\models\Search;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var $dataProvider array
 * @var $filterModel Search
 * @var $this View
 */


$this->title = Yii::t('rbac', 'Roles');
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
        <?= Html::a(Yii::t('rbac', 'Create role'), ['/rbac/role/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $filterModel,
            'columns' => [
                [
                    'attribute' => 'name',
                    'header' => Yii::t('rbac', 'Name'),
                    'options' => [
                        'style' => 'width: 20%'
                    ],
                ],
                [
                    'attribute' => 'description',
                    'header' => Yii::t('rbac', 'Description'),
                    'options' => [
                        'style' => 'width: 55%'
                    ],
                ],
                [
                    'attribute' => 'rule_name',
                    'header' => Yii::t('rbac', 'Rule name'),
                    'options' => [
                        'style' => 'width: 20%'
                    ],
                ],
                [
                    'class' => ActionColumn::class,
                    'template' => '{update} {delete}',
                    'urlCreator' => function ($action, $model) {
                        return Url::to(['/rbac/role/' . $action, 'name' => $model['name']]);
                    },
                    'options' => [
                        'style' => 'width: 5%'
                    ],
                ]
            ],
        ]) ?>
    </div>

<?php $this->endContent() ?>