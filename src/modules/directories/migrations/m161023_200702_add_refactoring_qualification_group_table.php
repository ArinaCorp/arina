<?php

use yii\db\Migration;

class m161023_200702_add_refactoring_qualification_group_table extends Migration
{
    public function up()
    {
        $this->addColumn('qualification','sort_order', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('qualification','sort_order');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
