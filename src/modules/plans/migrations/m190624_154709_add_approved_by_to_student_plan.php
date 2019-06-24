<?php

use yii\db\Migration;

/**
 * Class m190624_154709_add_approved_by_to_student_plan
 */
class m190624_154709_add_approved_by_to_student_plan extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('student_plan', 'approved_by', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('student_plan', 'approved_by');
    }
}
