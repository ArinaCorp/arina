<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170205_141213_create_table_cyclic_commission extends Migration
{
    use MigrationTrait;
    
    public function up()
    {
        $this->createTable('{{%cyclic_commission}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'head_id' => $this->integer(11),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%cyclic_commission}}');
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
