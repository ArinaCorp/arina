<?php

use yii\db\Migration;

class m180107_194604_rename_family_relation_table extends Migration
{
    public function up()
    {
        $this->renameTable('{{%family_ties}}','family_relations');
    }

    public function down()
    {
        $this->renameTable('{{%family_relations}}','family_ties');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m180107_194604_rename_family_relation_table cannot be reverted.\n";

        return false;
    }
    */
}
