<?php

use yii\db\Migration;

/**
 * Class m190613_183708_drop_old_geo_tables
 */
class m190613_183708_drop_old_geo_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('country');
        $this->dropTable('region');
        $this->dropTable('district');
        $this->dropTable('city');
        $this->dropTable('village');
        $this->dropTable('big_village');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190613_183708_drop_old_geo_tables cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_183708_drop_old_geo_tables cannot be reverted.\n";

        return false;
    }
    */
}
