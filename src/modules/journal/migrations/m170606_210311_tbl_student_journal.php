<?php

use yii\db\Migration;

class m170606_210311_tbl_student_journal extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ((\Yii::$app->db->driverName === 'mysql') && ($tableOptions === null)) {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(
            '{{%journal_student}}',
            [
                'id' => $this->primaryKey(),
                'load_id' => $this->integer()->notNull(),
                'student_id' => $this->integer()->notNull(),
                'type' => $this->integer()->notNull(),
                'date' => $this->date()->null(),
                'created_at' => $this->integer()->null(),
                'updated_at' => $this->integer()->null(),
            ],
            $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%journal_student}}');
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
