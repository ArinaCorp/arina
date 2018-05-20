<?php
/**
 * @var \yii\web\View $this
 * @var \app\modules\directories\models\StudyYear $year
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \app\modules\load\models\Load $model
 * @var \yii\widgets\ActiveForm $form
 */

use yii\bootstrap\Tabs;

?>


<?= Tabs::widget([
        'items' => [
            [
                'label' => '1-й курс',
                'active' => true,
                'content' => $this->render('_course', ['model' => $model, 'dataProvider' => $dataProvider, 'course' => 1], true),
            ],
            [
                'label' => '2-й курс',
                'content' => $this->render('_course', ['model' => $model, 'dataProvider' => $dataProvider, 'course' => 2], true),
            ],
            [
                'label' => '3-й курс',
                'content' => $this->render('_course', ['model' => $model, 'dataProvider' => $dataProvider, 'course' => 3], true),
            ],
            [
                'label' => '4-й курс',
                'content' => $this->render('_course', ['model' => $model, 'dataProvider' => $dataProvider, 'course' => 4], true),
            ],
        ]
    ]
); ?>