<?php

use yii\db\Migration;

class m170228_065825_add_data_fields extends Migration
{
    public function up()
    {
        $this->addColumn('employee', 'passport_issued_date', $this->date());
        $this->addColumn('employee', 'start_date', $this->date());
    }

    public function down()
    {
        $this->dropColumn('employee', 'passport_issued_date');
        $this->dropColumn('employee', 'start_date');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
