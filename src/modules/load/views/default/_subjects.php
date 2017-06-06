<?php
/**
 * @var MainController $this
 * @var StudyYear $year
 * @var CActiveDataProvider $dataProvider
 * @var Load $model
 * @var TbActiveForm $form
 */
?>


<?php $this->widget(
    'bootstrap.widgets.TbTabs',
    array(
        'type' => 'tabs',
        'tabs' => array(
            array(
                'label' => '1-й курс',
                'active' => true,
                'content' => $this->renderPartial('_course', array('model' => $model,  'dataProvider' => $dataProvider, 'course' => 1), true),
            ),
            array(
                'label' => '2-й курс',
                'content' => $this->renderPartial('_course', array('model' => $model, 'dataProvider' => $dataProvider, 'course' => 2), true),
            ),
            array(
                'label' => '3-й курс',
                'content' => $this->renderPartial('_course', array('model' => $model, 'dataProvider' => $dataProvider, 'course' => 3), true),
            ),
            array(
                'label' => '4-й курс',
                'content' => $this->renderPartial('_course', array('model' => $model, 'dataProvider' => $dataProvider, 'course' => 4), true),
            ),
        )
    )
); ?>