<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m161203_082126_tbl_family_ties extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%family_ties}}', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer(11),
            'type_id' => $this->integer(11),
            'last_name' => $this->string()->notNull(),
            'first_name' => $this->string()->notNull(),
            'middle_name' => $this->string()->notNull(),
            'work_place' => $this->string(),
            'work_position' => $this->string(),
            'phone1' => $this->string(),
            'phone2' => $this->string(),
            'email' => $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%family_ties}}');
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
