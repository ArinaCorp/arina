<?php

use yii\db\Migration;

/**
 * Class m190622_214025_add_student_id_to_user_table
 */
class m190622_214025_add_student_id_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user','student_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user','student_id');
    }

}
