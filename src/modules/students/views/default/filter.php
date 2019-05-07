<?php

use kartik\export\ExportMenu;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use \app\modules\students\models\Exemption;
use \app\modules\students\models\ExemptionStudentRelation;

/* @var $this yii\web\View */
/* @var $search app\modules\students\models\StudentSearch */
/* @var $student yii\data\ActiveDataProvider */
/* @var $group yii\data\ActiveDataProvider */
/* @var $exemption yii\data\ActiveDataProvider */
/* @var $group_list yii\data\ActiveDataProvider */
/* @var $student_list yii\data\ActiveDataProvider */
/* @var $aliasName yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Students filter');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>


    <p>
        <?= Html::a(Yii::t('app', 'List students'), ['index'], ['class' => 'btn btn-success']) ?>
    </p>


    <?php echo $this->render('_filter_form', [
            'student' => $student,
            'group' => $group,
            'exemption' => $exemption,
            'search' => $search,
            'aliasName' => $aliasName
        ]
    );
    ?>

    <?php
    $gridColumns = [
        ['class' => 'yii\grid\SerialColumn'],
        'last_name',
        'first_name',
        'middle_name',
        [
            'label' => Yii::t('app', 'Exemptions'),
            'visible' => !empty($search->exemptions),
            'value' => function ($model) {
                return Exemption::getExemptionTitleById(ExemptionStudentRelation::getExemptionIdByStudentId($model->id));
            }
        ],
        [
            'format' => 'raw',
            'contentOptions' => ['style' => 'text-align:center;width:70px;'],
            'value' => function ($model) use ($search) {
                return Html::a(FA::icon('eye'), Url::to(['/students/default/view', 'id' => $model->primaryKey]), [
                        'title' => Yii::t('app', 'View'),
                        'style' => 'text-align:center;margin:0 5px',
                        'target'=>'_blank', 'data-pjax'=>"0"
                    ]) . Html::a(FA::icon('file'), ['/students/default/document', 'params' => ['student_id' => $model->primaryKey, 'search' =>Yii::$app->request->queryParams]], [
                        'title' => Yii::t('app', 'Print'),
                        'style' => 'text-align:center;margin:0 5px',
                        'target'=>'_blank', 'data-pjax'=>"0"
                    ]);
            }
        ],
    ];
    ?>

    <?php Pjax::begin(['id' => 'notes']); ?>
    <?= GridView::widget([
        'dataProvider' => $student,
        'columns' => $gridColumns
    ]); ?>
    <?php Pjax::end(); ?>
    <div class="m-100" style="padding-bottom: 100px;"></div>

</div>