<?php

use yii\db\Migration;

class m170621_215904_tbl_record_refactor extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('{{%journal_record_types}}', 'audience', $this->integer(11)->null()->defaultValue(null)->after('homework'));
        $this->alterColumn("{{%journal_record}}", 'number', $this->integer(11)->null()->defaultValue(null));
        $this->alterColumn("{{%journal_record}}", 'number_in_day', $this->integer(11)->null()->defaultValue(null));
        $this->alterColumn("{{%journal_record}}", 'hours', $this->integer(11)->null()->defaultValue(null));
        $this->alterColumn("{{%journal_record}}", 'audience_id', $this->integer(11)->null()->defaultValue(null));
    }

    public function safeDown()
    {
        echo "m170621_215904_tbl_record_refactor cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170621_215904_tbl_record_refactor cannot be reverted.\n";

        return false;
    }
    */
}
