<?php

use yii\db\Migration;

class m170621_214244_tbl_record_type_refactor extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%journal_record_types}}', 'audience', $this->integer(11)->null()->defaultValue(0)->after('homework'));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%journal_record_types}}', 'audience');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170621_214244_tbl_record_type_refactor cannot be reverted.\n";

        return false;
    }
    */
}
