<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m161208_203645_tbl_student_history extends Migration
{
    use MigrationTrait;

    public function up()
    {
        $this->createTable('{{%students_history}}', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer(),
            'parent_id' => $this->integer(),
            'study_year_id' => $this->integer(),
            'date' => $this->date(),
            'speciality_qualification_id' => $this->integer(),
            'action_type' => $this->smallInteger(4),
            'payment_type' => $this->smallInteger(4),
            'group_id' => $this->integer(11),
            'course' => $this->smallInteger(4),
            'command' => $this->string(128),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $this->getTableOptions());
    }

    public function down()
    {
        $this->dropTable('{{%students_history}}');
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
