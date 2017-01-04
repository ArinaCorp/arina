<?php

use yii\db\Migration;

class m161210_195125_study_year_active_field extends Migration
{
    public function up()
    {
        $this->addColumn('{{%study_years}}', 'active', $this->boolean());
    }

    public function down()
    {
        $this->dropColumn('{{%study_years}}', 'active');
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
