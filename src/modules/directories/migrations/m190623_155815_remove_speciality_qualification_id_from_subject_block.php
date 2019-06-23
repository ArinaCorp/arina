<?php

use yii\db\Migration;

/**
 * Class m190623_155815_remove_speciality_qualification_id_from_subject_block
 */
class m190623_155815_remove_speciality_qualification_id_from_subject_block extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey(
            'fk-subject_block-speciality_qualification_id',
            'subject_block'
        );

        $this->dropIndex(
            'idx-subject_block-speciality_qualification_id',
            'subject_block'
        );

        $this->dropColumn('subject_block', 'speciality_qualification_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('subject_block', 'speciality_qualification_id', $this->integer());

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
    }
}
