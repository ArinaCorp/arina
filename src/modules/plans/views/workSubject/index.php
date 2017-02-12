<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/** @var $this yii\web\View
 * @var $model app\modules\directories\models\subject\Subject
 * @var $form ActiveForm
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $searchModel \app\modules\directories\models\subject\SubjectSearch */

$this->title = Yii::t('app', 'Subjects');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="subject-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Create work subject'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'code',
            'short_name',
            'practice',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
