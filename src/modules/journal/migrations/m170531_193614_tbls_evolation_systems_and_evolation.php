<?php

use yii\db\Migration;

class m170531_193614_tbls_evolation_systems_and_evolation extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ((\Yii::$app->db->driverName === 'mysql') && ($tableOptions === null)) {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(
            '{{%evaluation_systems}}',
            [
                'id' => $this->primaryKey(),
                'title' => $this->string(128)->notNull(),
                'created_at' => $this->integer()->null(),
                'updated_at' => $this->integer()->null(),
            ],
            $tableOptions
        );
        $this->createTable(
            '{{%evaluations}}',
            [
                'id' => $this->primaryKey(),
                'system_id' => $this->integer()->notNull(),
                'value' => $this->string(128)->notNull(),
                'created_at' => $this->integer()->null(),
                'updated_at' => $this->integer()->null(),
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
