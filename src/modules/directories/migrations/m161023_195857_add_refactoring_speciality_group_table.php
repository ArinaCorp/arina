<?php

use yii\db\Migration;

class m161023_195857_add_refactoring_speciality_group_table extends Migration
{
    public function up()
    {
        $this->addColumn('speciality','short_title', $this->string());
    }

    public function down()
    {
        $this->dropColumn('speciality', 'short_title');
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
