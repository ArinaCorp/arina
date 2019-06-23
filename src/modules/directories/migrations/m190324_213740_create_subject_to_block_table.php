<?php

use yii\db\Migration;

/**
 * Handles the creation of table `subject_to_block`.
 */
class m190324_213740_create_subject_to_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('subject_to_block', [
            'id' => $this->primaryKey(),
            'subject_id' => $this->integer(11),
            'block_id' => $this->integer(11),
        ]);

        $this->createIndex(
            'idx-stb-subject_id',
            'subject_to_block',
            'subject_id'
        );

        $this->addForeignKey(
            'fk-stb-subject_id',
            'subject_to_block',
            'subject_id',
            'subject',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'idx-stb-block_id',
            'subject_to_block',
            'block_id'
        );

        $this->addForeignKey(
            'fk-stb-block_id',
            'subject_to_block',
            'block_id',
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

        $this->dropForeignKey(
            'fk-stb-subject_id',
            'subject_to_block'
        );

        $this->dropIndex(
            'idx-stb-subject_id',
            'subject_to_block'
        );

        $this->dropForeignKey(
            'fk-stb-block_id',
            'subject_to_block'
        );

        $this->dropIndex(
            'idx-stb-block_id',
            'subject_to_block'
        );

        $this->dropTable('subject_to_block');
    }
}
