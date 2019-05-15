<?php

use yii\db\Migration;

/**
 * Class m190513_204248_add_parent_id_to_subject_cycle
 */
class m190513_204248_add_parent_id_to_subject_cycle extends Migration
{
    public function up()
    {
        $this->addColumn('subject_cycle', 'parent_id', $this->integer()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('subject_cycle', 'parent_id');
    }
}
