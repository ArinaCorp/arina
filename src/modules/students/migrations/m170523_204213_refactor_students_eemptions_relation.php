<?php

use yii\db\Migration;

class m170523_204213_refactor_students_eemptions_relation extends Migration
{
    public function up()
    {
        $this->addColumn('{{%exemptions_students_relations}}', 'date_start', $this->date());
        $this->addColumn('{{%exemptions_students_relations}}', 'date_end', $this->date());
        $this->addColumn('{{%exemptions_students_relations}}', 'information', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('{{%exemptions_students_relations}}', 'date_start');
        $this->dropColumn('{{%exemptions_students_relations}}', 'date_end');
        $this->dropColumn('{{%exemptions_students_relations}}', 'information');
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
