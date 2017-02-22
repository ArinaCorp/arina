<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170213_214153_tbl_curator_group extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%curator_group}}', [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer(11),
            'teacher_id' => $this->integer(11),
            'type' => $this->integer(2),
            'date' => $this->date(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%curator_group}}');
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
