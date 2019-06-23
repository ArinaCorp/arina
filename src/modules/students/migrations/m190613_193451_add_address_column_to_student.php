<?php

use yii\db\Migration;

/**
 * Class m190613_193451_add_address_column_to_student
 */
class m190613_193451_add_address_column_to_student extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('student', 'address', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m190613_193451_add_address_column_to_student cannot be reverted.\n";
        $this->dropColumn('student', 'address');
//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_193451_add_address_column_to_student cannot be reverted.\n";

        return false;
    }
    */
}
