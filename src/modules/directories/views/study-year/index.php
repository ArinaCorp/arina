<?php

use yii\helpers\Html;
use app\modules\directories\models\study_year\StudyYear;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $currentYear StudyYear */
/* @var $studyYears StudyYear[] */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('app', 'Study years list');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$actionUrl = Url::to(['set-current-year']);

$js = '';

$js .= <<<JS
    $("[name='current_year']").on('change', function(){
        $.ajax({
            url: '$actionUrl', 
            data: {
                id: $(this).val()
            },
            success: function(res){
                if(res) { 
                    $.notify({
                        "icon": "glyphicon glyphicon-info-sign",
                        "title": '',
                        "message": res.message,
                    }, {
                        "type": "info",
                        "allow_dismiss": true,
                        "newest_on_top": true,
                        "placement": {"from": "top", "align": "right"},
                        "delay": "500"
                    })
                }
            },
        })
    });
JS;

$this->registerJS($js);
?>

<div class="study-year-index">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <?= Html::label(Yii::t('app', 'Current study year')) ?>
                <?= Html::dropDownList('current_year', $currentYear->id, $studyYears, [
                    'class' => 'form-control'
                ]) ?>
            </div>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Adding new study year'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
            ],
        ],
    ]); ?>
</div>
