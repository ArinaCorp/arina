<?php

use yii\db\Migration;

class m161111_064314_refactor_student_group_tbl extends Migration
{
    public function up()
    {
        $this->renameColumn('{{%student_group}}', 'string', 'date');
    }

    public function down()
    {
        $this->renameColumn('{{%student_group}}', 'date', 'string');
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
