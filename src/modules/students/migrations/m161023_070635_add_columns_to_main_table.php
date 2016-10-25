<?php

use yii\db\Migration;

class m161023_070635_add_columns_to_main_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%student}}','photo',$this->string(255));
        $this->addColumn('{{%student}}','passport_issued',$this->string(255));
    }

    public function down()
    {
        $this->dropColumn('{{%student}}','photo');
        $this->dropColumn('{{%student}}','passport_issued');
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
