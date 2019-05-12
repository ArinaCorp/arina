<?php

use yii\db\Migration;

/**
 * Handles the creation of table `student_plan`.
 */
class m190512_163222_create_student_plan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('student_plan', [
            'id' => $this->primaryKey(11),
            'student_id' => $this->integer(11),
            'course' => $this->integer(11),
            'semester' => $this->integer(11),
            'work_plan_id' => $this->integer(11),
            'subject_block_id' => $this->integer(11),
            'created' => $this->timestamp(),
            'updated' => $this->timestamp(),
        ]);

        $this->createIndex(
            'idx-student_plan-student_id',
            'student_plan',
            'student_id'
        );

        $this->addForeignKey(
            'fk-student_plan-student_id',
            'student_plan',
            'student_id',
            'student',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-student_plan-work_plan_id',
            'student_plan',
            'work_plan_id'
        );

        $this->addForeignKey(
            'fk-student_plan-student_id',
            'student_plan',
            'work_plan_id',
            'work_plan',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-student_plan-subject_block_id',
            'student_plan',
            'subject_block_id'
        );

        $this->addForeignKey(
            'fk-student_plan-subject_block_id',
            'student_plan',
            'subject_block_id',
            'subject_block',
            'id',
            'CASCADE',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->dropIndex(
            'idx-student_plan-student_id',
            'student_plan'
        );

        $this->dropForeignKey(
            'fk-student_plan-student_id',
            'student_plan'
        );

        $this->dropIndex(
            'idx-student_plan-work_plan_id',
            'student_plan'
        );

        $this->dropForeignKey(
            'fk-student_plan-work_plan_id',
            'student_plan'
        );

        $this->dropIndex(
            'idx-student_plan-subject_block_id',
            'student_plan'
        );

        $this->dropForeignKey(
            'fk-student_plan-subject_block_id',
            'student_plan'
        );

        $this->dropTable('student_plan');
    }
}
