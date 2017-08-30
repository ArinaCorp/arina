<?php

use yii\db\Migration;

class m170515_072615_update_accounting_mounth extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('accounting_mounth', 'date');
        $this->addColumn('accounting_mounth', 'date', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('accounting_mounth', 'date');
        $this->addColumn('accounting_mounth', 'date', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170515_072615_update_accounting_mounth cannot be reverted.\n";

        return false;
    }
    */
}
