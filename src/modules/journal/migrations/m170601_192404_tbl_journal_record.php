<?php

use yii\db\Migration;

class m170601_192404_tbl_journal_record extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ((\Yii::$app->db->driverName === 'mysql') && ($tableOptions === null)) {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(
            '{{%journal_record}}',
            [
                'id' => $this->primaryKey(),
                'load_id' => $this->integer()->notNull(),
                'teacher_id' => $this->integer()->notNull(),
                'type' => $this->integer()->notNull(),
                'date' => $this->date()->null(),
                'description' => $this->text()->null(),
                'home_work' => $this->text()->null(),
                'number' => $this->integer()->notNull(),
                'number_in_day' => $this->integer()->notNull(),
                'hours' => $this->integer()->notNull(),
                'audience_id' => $this->integer()->notNull(),
                'created_at' => $this->integer()->null(),
                'updated_at' => $this->integer()->null(),
            ],
            $tableOptions
        );
        $this->createTable(
            '{{%journal_mark}}',
            [
                'id' => $this->primaryKey(),
                'record_id' => $this->integer()->notNull(),
                'student_id' => $this->integer()->notNull(),
                'presence' => $this->boolean()->defaultValue(1),
                'not_presence_reason_id' => $this->integer()->null(),
                'evaluation_system_id' => $this->integer()->null(),
                'evaluation_id' => $this->integer()->null(),
                'date' => $this->date()->null(),
                'retake_evaluation_id' => $this->integer()->null(),
                'retake_date' => $this->date()->null(),
                'comment' => $this->text(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
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
