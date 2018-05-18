<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel nullref\admin\models\AdminSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('admin', 'Admins');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('admin', 'Create Admin'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            'email:email',
            'firstName',
            'lastName',
            'role',
            // 'status',
            // 'passwordHash',
            // 'passwordResetToken',
            // 'passwordResetExpire',
            // 'createdAt',
            // 'updatedAt',
            // 'authKey',
            // 'emailConfirmToken:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
