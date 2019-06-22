<?php

use yii\db\Migration;

/**
 * Class m190613_215613_alter_country_id_region_id_in_student
 */
class m190613_215613_alter_country_id_region_id_in_student extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('student', 'country_id', $this->string());
        $this->alterColumn('student', 'region_id', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('student', 'country_id', $this->integer());
        $this->alterColumn('student', 'region_id', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_215613_alter_country_id_region_id_in_student cannot be reverted.\n";

        return false;
    }
    */
}
