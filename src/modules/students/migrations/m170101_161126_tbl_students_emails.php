<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170101_161126_tbl_students_emails extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%students_emails}}', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer(11),
            'email' => $this->string(64),
            'comment' => $this->string(128),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%students_emails}}');
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
