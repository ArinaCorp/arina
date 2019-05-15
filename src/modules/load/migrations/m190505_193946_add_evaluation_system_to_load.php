<?php

use yii\db\Migration;

/**
 * Class m190505_193946_add_evaluation_system_to_load
 */
class m190505_193946_add_evaluation_system_to_load extends Migration
{
    public function up()
    {
        $this->addColumn('load', 'evaluation_system_id', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('load', 'evaluation_system_id');
    }
}
