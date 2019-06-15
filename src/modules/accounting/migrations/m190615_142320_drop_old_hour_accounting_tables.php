<?php

use yii\db\Migration;

/**
 * Class m190615_142320_drop_old_hour_accounting_tables
 */
class m190615_142320_drop_old_hour_accounting_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('accounting_mounth');
        $this->dropTable('accounting_year');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190615_142320_drop_old_hour_accounting_tables cannot be reverted.\n";
        return false;
    }
}
