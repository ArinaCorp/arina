<?php

use yii\bootstrap\Html;
use yii\web\View;
use yii\helpers\Url;

use app\modules\plans\models\WorkPlan;
use app\modules\plans\widgets\Graph;
/**
 * @var $this View
 * @var $model WorkPlan
 */

$this->title = $model->specialityQualification->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('plans', 'Study plans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

$this->menu = array(
    array(
        'label' => 'Додати предмет',
        'type' => 'info',
        'url' => $this->createUrl('addSubject', array('id' => $model->id)),
    ),
    array(
        'label' => 'Повернутись',
        'type' => 'primary',
        'url' => $this->createUrl('index'),
    ),
);
?>
<?php $this->renderPartial('_subjects', array('model' => $model)); ?>