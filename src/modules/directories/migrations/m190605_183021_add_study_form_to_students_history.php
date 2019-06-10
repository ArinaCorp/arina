<?php

use yii\db\Migration;

/**
 * Class m190605_183021_add_study_form_to_student_history
 */
class m190605_183021_add_study_form_to_students_history extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            'students_history',
            'study_form_id',
            $this->integer(11)
        );

        $this->createIndex(
            'idx-students_history-study_form_id',
            'students_history',
            'study_form_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-students_history-study_form_id', 'students_history');
        $this->dropColumn('students_history', 'study_form_id');
    }

}
