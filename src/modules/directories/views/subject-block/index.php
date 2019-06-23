<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/** @var $this yii\web\View
 * @var $model app\modules\directories\models\subject_block\SubjectBlock
 * @var $form ActiveForm
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $searchModel \app\modules\directories\models\subject_block\SubjectBlockSearch
 */

$this->title = Yii::t('app', 'Subject blocks');
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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create subject block'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'workPlanTitle',
            'course',
            'semester',
            'subjectCount',
            [
                'attribute' => 'updated',
                'format' => 'datetime'
            ],
            [
                'attribute' => 'created',
                'format' => 'datetime'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
