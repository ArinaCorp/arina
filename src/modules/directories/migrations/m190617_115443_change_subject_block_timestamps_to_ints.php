<?php

use yii\db\Migration;

/**
 * Class m190617_115443_change_subject_block_timestamps_to_ints
 */
class m190617_115443_change_subject_block_timestamps_to_ints extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('subject_block', 'created', $this->integer());
        $this->alterColumn('subject_block', 'updated', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('subject_block', 'created', $this->timestamp());
        $this->alterColumn('subject_block', 'updated', $this->timestamp());
    }
}
