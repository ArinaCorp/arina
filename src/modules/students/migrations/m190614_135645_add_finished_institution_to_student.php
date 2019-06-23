<?php

use yii\db\Migration;

/**
 * Class m190614_135645_add_finished_institution_to_student
 */
class m190614_135645_add_finished_institution_to_student extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('student', 'finished_inst', $this->string());
        $this->addColumn('student', 'finished_year', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('student', 'finished_inst');
        $this->dropColumn('student', 'finished_year');
    }

}
