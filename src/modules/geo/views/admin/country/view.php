<?php

use app\modules\geo\models\Country;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model Country */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Countries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-view">

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
            'code',
            'geoname_id',
            'capital_geoname_id',
            'language_code',
            'currency_code',
            'timezone_code',
            'latitude',
            'longitude',
            'name_en',
            'name',
            'continentCode',
            'continentName',
            'regionCode',
            'regionName',
            'subregionCode',
            'subregionName',
            'measurementSystemCode',
            'measurementSystemName',
//            'localeCodes',
//            'localeNames',
//            'languageCodes',
//            'languageNames',
            'localeCode',
            'localeName',
            'languageCode',
            'languageName',
            'currencyCode',
            'currencyName',
            'timezoneCode',
            'timezoneName',
        ],
    ]) ?>

</div>
