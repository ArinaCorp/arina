<?php

use yii\db\Migration;

/**
 * Class m190623_145314_refactor_subject_block_table
 */
class m190623_145314_refactor_subject_block_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey(
            'fk-subject_block-speciality_id',
            'subject_block'
        );

        $this->dropIndex(
            'idx-subject_block-speciality_id',
            'subject_block'
        );

        $this->renameColumn('subject_block', 'speciality_id', 'speciality_qualification_id');

        $this->createIndex(
            'idx-subject_block-speciality_qualification_id',
            'subject_block',
            'speciality_qualification_id'
        );

        $this->addForeignKey(
            'fk-subject_block-speciality_qualification_id',
            'subject_block',
            'speciality_qualification_id',
            'speciality_qualification',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addColumn('subject_block', 'semester', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('subject_block', 'semester');

        $this->dropForeignKey(
            'fk-subject_block-speciality_qualification_id',
            'subject_block'
        );

        $this->dropIndex(
            'idx-subject_block-speciality_qualification_id',
            'subject_block'
        );

        $this->renameColumn('subject_block', 'speciality_qualification_id', 'speciality_id');

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

}
