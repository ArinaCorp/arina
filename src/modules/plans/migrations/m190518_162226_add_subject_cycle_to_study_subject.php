<?php

use yii\db\Migration;

/**
 * Class m190518_162226_add_subject_cycle_to_study_subject
 */
class m190518_162226_add_subject_cycle_to_study_subject extends Migration
{
    public function up()
    {
        $this->addColumn('study_subject', 'subject_cycle_id', $this->integer());

        $this->createIndex(
            'idx-study_subject-subject_cycle_id',
            'study_subject',
            'subject_cycle_id'
        );

        $this->addForeignKey(
            'fk-study_subject-subject_cycle_id',
            'study_subject',
            'subject_cycle_id',
            'subject_cycle',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-study_subject-subject_cycle_id',
            'study_subject'
        );

        $this->dropIndex(
            'idx-study_subject-subject_cycle_id',
            'study_subject'
        );

        $this->dropColumn('study_subject', 'subject_cycle_id');
    }
}
