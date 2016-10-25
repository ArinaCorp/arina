<?php

use yii\db\Migration;

class m161013_074655_table_refactoring extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%student}}','form_of_study_id');
        $this->addColumn('{{%student}}','birth_certificate',$this->string(10));
    }

    public function down()
    {
        $this->addColumn('{{%student}}','form_of_study_id',$this->smallInteger());
        $this->dropColumn('{{%student}}','birth_certificate');
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
