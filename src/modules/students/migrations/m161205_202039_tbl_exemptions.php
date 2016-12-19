<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m161205_202039_tbl_exemptions extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%exemptions}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(64),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%exemptions}}');
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
