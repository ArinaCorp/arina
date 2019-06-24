<?php

use yii\db\Migration;

/**
 * Class m190623_161848_remake_subject_to_block_table_into_work_subject_to_subject_block
 */
class m190623_161848_remake_subject_to_block_table_into_work_subject_to_subject_block extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey(
            'fk-stb-subject_id',
            'subject_to_block'
        );

        $this->dropIndex(
            'idx-stb-subject_id',
            'subject_to_block'
        );

        $this->renameColumn('subject_to_block', 'subject_id', 'work_subject_id');

        $this->createIndex(
            'idx-stb-work_subject_id',
            'subject_to_block',
            'work_subject_id'
        );

        $this->addForeignKey(
            'fk-stb-work_subject_id',
            'subject_to_block',
            'work_subject_id',
            'work_subject',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->renameTable('subject_to_block', 'work_subject_to_subject_block');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable('work_subject_to_subject_block', 'subject_to_block');

        $this->dropForeignKey(
            'fk-stb-work_subject_id',
            'subject_to_block'
        );

        $this->dropIndex(
            'idx-stb-work_subject_id',
            'subject_to_block'
        );

        $this->renameColumn('subject_to_block', 'work_subject_id', 'subject_id');

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

    }

}
