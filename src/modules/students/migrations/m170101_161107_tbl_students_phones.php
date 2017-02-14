<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170101_161107_tbl_students_phones extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%students_phones}}', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer(11),
            'phone' => $this->string(64),
            'comment' => $this->string(128),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%students_phones}}');
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
