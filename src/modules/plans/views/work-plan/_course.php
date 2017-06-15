<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use app\modules\plans\models\WorkSubject;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $model WorkSubject
 * @var $subjectDataProvider ActiveDataProvider
 * @var $course integer
 */

switch ($course) {
    case 1:
        $fall = 0;
        $spring = 1;
        break;
    case 2:
        $fall = 2;
        $spring = 3;
        break;
    case 3:
        $fall = 4;
        $spring = 5;
        break;
    case 4:
        $fall = 6;
        $spring = 7;
        break;
    default:
        $fall = 0;
        $spring = 1;
}
?>

<?= GridView::widget([
    'dataProvider' => $subjectDataProvider,
    'columns' => [
        'subject_id'
    ],
]);
?>