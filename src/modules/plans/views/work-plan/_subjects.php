<?php
/**
 * @var WorkController $this
 * @var WorkPlan $model
 */
?>
    <h3>Предмети</h3>
<?php $this->widget(
    'bootstrap.widgets.TbTabs',
    array(
        'type' => 'tabs',
        'tabs' => array(
            array(
                'label' => '1-й курс',
                'active' => true,
                'content' => $this->renderPartial('_course', array('model' => $model, 'course' => 1), true),
            ),
            array(
                'label' => '2-й курс',
                'content' => $this->renderPartial('_course', array('model' => $model, 'course' => 2), true),
            ),
            array(
                'label' => '3-й курс',
                'content' => $this->renderPartial('_course', array('model' => $model, 'course' => 3), true),
            ),
            array(
                'label' => '4-й курс',
                'content' => $this->renderPartial('_course', array('model' => $model, 'course' => 4), true),
            ),
        )
    )
); ?>