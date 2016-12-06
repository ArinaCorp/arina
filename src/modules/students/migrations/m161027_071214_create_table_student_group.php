<?php

use yii\db\Migration;
use nullref\core\traits\MigrationTrait;

class m161027_071214_create_table_student_group extends Migration
{
    use MigrationTrait;
    public function up()
    {

        $this->createTable('{{%student_group}}', [
            'id' => $this->primaryKey(),
            'string'=> $this->date(),
            'type'=>$this->integer(1),
            'group_id' =>$this->integer(11),
            'student_id'=>$this->integer(11),
            'comment'=>$this->string(128),
            'funding_id'=>$this->integer(11),
        ], $this->getTableOptions());
    }
    public function down()
    {
        $this->delete('{{%student_group}}');
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
