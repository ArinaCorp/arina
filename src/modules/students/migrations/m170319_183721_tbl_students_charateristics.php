<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170319_183721_tbl_students_charateristics extends Migration
{
    use MigrationTrait;
    public function up()
    {
        $this->createTable('{{%characteristics_type}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(64),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->getTableOptions());
        $this->createTable('{{%students_characteristics}}', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer(11),
            'type_id' => $this->integer(11),
            'title' => $this->string(128),
            'date' => $this->date(),
            'from' => $this->string(128),
            'text' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%characteristics_type}}');
        $this->dropTable('{{%students_characteristics}}');
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
