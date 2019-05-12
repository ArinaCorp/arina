<?php

use yii\db\Migration;

/**
 * Handles the creation of table `subject_block`.
 */
class m190324_213550_create_subject_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('subject_block', [
            'id' => $this->primaryKey(11),
            'speciality_id' => $this->integer(11),
            'course' => $this->integer(11),
            'created' => $this->timestamp(),
            'updated' => $this->timestamp(),
        ]);

        $this->createIndex(
            'idx-subject_block-speciality_id',
            'subject_block',
            'speciality_id'
        );

        $this->addForeignKey(
            'fk-subject_block-speciality_id',
            'subject_block',
            'speciality_id',
            'speciality',
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

        $this->dropForeignKey(
            'idx-subject_block-speciality_id',
            'subject_block'
        );

        $this->dropIndex(
            'fk-subject_block-speciality_id',
            'subject_block'
        );

        $this->dropTable('subject_block');
    }
}
