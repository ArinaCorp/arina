<?php

use yii\db\Migration;

/**
 * Class m190613_193148_rename_district_id_to_city_id
 */
class m190613_193148_rename_district_id_to_city_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('student', 'district_id', 'city_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m190613_193148_rename_district_id_to_city_id cannot be reverted.\n";
        $this->renameColumn('student', 'city_id', 'district_id');
//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_193148_rename_district_id_to_city_id cannot be reverted.\n";

        return false;
    }
    */
}
