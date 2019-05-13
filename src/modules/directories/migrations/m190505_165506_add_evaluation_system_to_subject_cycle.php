<?php

use yii\db\Migration;

/**
 * Class m190505_165506_add_evaluation_system_to_subject_cycle
 */
class m190505_165506_add_evaluation_system_to_subject_cycle extends Migration
{
    public function up()
    {
        $this->addColumn('subject_cycle', 'evaluation_system_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('subject_cycle', 'evaluation_system_id');
    }
}
