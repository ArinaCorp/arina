<?php

use yii\db\Migration;

/**
 * Class m190623_201314_add_group_id_to_student_plan
 */
class m190623_201314_add_group_id_to_student_plan extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('student_plan', 'group_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('student_plan', 'group_id');
    }

}
