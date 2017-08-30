<?php

use yii\db\Migration;

class m170515_074001_update_accounting_year extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('accounting_year', 'mounth');
        $this->addColumn('accounting_year', 'mounth', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('accounting_year', 'mounth');
        $this->addColumn('accounting_year', 'mounth', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170515_074001_update_accounting_year cannot be reverted.\n";

        return false;
    }
    */
}
