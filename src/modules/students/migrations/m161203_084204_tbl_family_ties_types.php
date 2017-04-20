<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m161203_084204_tbl_family_ties_types extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%family_ties_types}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(64),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%family_ties_types}}');
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
