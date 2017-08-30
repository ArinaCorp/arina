<?php

use yii\db\Migration;

class m170618_133732_tbl_student_not_presence extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ((\Yii::$app->db->driverName === 'mysql') && ($tableOptions === null)) {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(
            '{{%not_presence_type}}',
            [
                'id' => $this->primaryKey(),
                'title' => $this->string(128)->notNull(),
                'label' => $this->string(12)->null()->defaultValue(null),
                'is_great' => $this->boolean()->defaultValue(0),
                'percent_hours' => $this->integer()->defaultValue(100),
                'created_at' => $this->integer()->null(),
                'updated_at' => $this->integer()->null(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%not_presence_type}}');
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
