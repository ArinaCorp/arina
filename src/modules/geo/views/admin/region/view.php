<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\geo\models\Region */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Regions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-view">

    <div class="row">
        <div class="col-lg-12">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'List'), Url::to('index'), ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'country_code',
            'division_code',
            'geoname_id',
            'capital_geoname_id',
//            'language_codes',
            'timezone_code',
            'latitude',
            'longitude',
            'name_en',
            'code',
            'name',
//            'languageCodes',
            'countryName',
            'timezoneName',
        ],
    ]) ?>

</div>
