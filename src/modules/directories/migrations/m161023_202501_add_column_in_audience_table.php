<?php

use yii\db\Migration;

class m161023_202501_add_column_in_audience_table extends Migration
{
    public function up()
    {
        $this->addColumn('directories_audience','capacity', $this->integer());
    }

    public function down()
    {
        $this->dropColumn('directories_audience','capacity');
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
