<?php

use yii\db\Migration;

class m170621_075956_tbl_record_types extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ((\Yii::$app->db->driverName === 'mysql') && ($tableOptions === null)) {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable(
            '{{%journal_record_types}}',
            [
                'id' => $this->primaryKey(),
                'title' => $this->string(128)->notNull(),
                'description' => $this->boolean()->defaultValue(0),
                'homework' => $this->boolean()->defaultValue(0),
                'hours' => $this->boolean()->defaultValue(0),
                'present' => $this->boolean()->defaultValue(0),
                'date' => $this->boolean()->defaultValue(0),
                'n_pp' => $this->boolean()->defaultValue(0),
                'n_in_day' => $this->boolean()->defaultValue(0),
                'ticket' => $this->boolean()->defaultValue(0),
                'is_report' => $this->boolean()->defaultValue(0),
                'report_title' => $this->string(182)->notNull(),
                'work_type_id' => $this->integer()->notNull(),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%journal_record_types}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170621_075956_tbl_record_types cannot be reverted.\n";

        return false;
    }
    */
}
