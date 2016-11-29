<?php

use yii\db\Migration;

class m161025_055552_refactor_table_main extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%student}}','student_code');
        $this->addColumn('{{%student}}','student_code',$this->string(12));
        $this->dropColumn('{{%student}}','sseed_id');
        $this->addColumn('{{%student}}','sseed_id',$this->string(10));
        $this->dropColumn('{{%student}}','user_id');
        $this->addColumn('{{%student}}','user_id', $this->integer(11));
        $this->dropColumn('{{%student}}','passport_code');
        $this->addColumn('{{%student}}','passport_code',$this->string(12));
        $this->dropColumn('{{%student}}','tax_id');
        $this->addColumn('{{%student}}','tax_id',$this->string(10));
        $this->addColumn('{{%student}}','passport_issued_date',$this->date());
    }

    public function down()
    {
        $this->alterColumn('{{%student}}','student_code',$this->string(12)->unique());
        $this->alterColumn('{{%student}}','sseed_id',$this->integer(11)->unique());
        $this->alterColumn('{{%student}}','user_id', $this->integer(11)->unique());
        $this->alterColumn('{{%student}}','passport_code',$this->string(12)->unique());
        $this->alterColumn('{{%student}}','tax_id',$this->string(10)->unique());
        $this->dropColumn('{{%student}}','passport_issued_date');
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
