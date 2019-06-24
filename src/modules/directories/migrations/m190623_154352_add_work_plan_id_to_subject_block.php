<?php

use yii\db\Migration;

/**
 * Class m190623_154352_add_work_plan_id_to_subject_block
 */
class m190623_154352_add_work_plan_id_to_subject_block extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('subject_block', 'work_plan_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('subject_block', 'work_plan_id');
    }

}
