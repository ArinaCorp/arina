<?php

use yii\db\Migration;

class m170622_064724_tbl_mark_refactor extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%journal_mark}}', 'ticket', $this->string(128)->null()->defaultValue(null)->after('evaluation_id'));
        $this->addColumn('{{%journal_mark}}', 'retake_ticket', $this->string(128)->null()->defaultValue(null)->after('retake_evaluation_id'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%journal_mark}}', 'ticket');
        $this->dropColumn('{{%journal_mark}}', 'retake_ticket');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170622_064724_tbl_mark_refactor cannot be reverted.\n";

        return false;
    }
    */
}
