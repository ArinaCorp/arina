<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m170317_104234_tbls_social_networks extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%social_networks}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(64),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->getTableOptions());
        $this->createTable('{{%students_social_networks}}', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer(11),
            'network_id' => $this->integer(11),
            'url' => $this->string(128),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%social_networks}}');
        $this->dropTable('{{%students_social_networks}}');
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
